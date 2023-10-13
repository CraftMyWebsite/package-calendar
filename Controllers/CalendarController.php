<?php

namespace CMW\Controller\Calendar;

use CMW\Controller\users\UsersController;;

use CMW\Manager\Flash\Alert;
use CMW\Manager\Flash\Flash;
use CMW\Manager\Lang\LangManager;
use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Manager\Views\View;
use CMW\Model\Calendar\CalendarModel;
use CMW\Model\Users\UsersModel;
use CMW\Utils\Redirect;
use CMW\Utils\Utils;
use JetBrains\PhpStorm\NoReturn;

/**
 * Class: @CalendarController
 * @package Calendar
 * @author Z0mb
 * @version 0.0.1
 */
class CalendarController extends AbstractController
{
    #[Link(path: "/", method: Link::GET, scope: "/cmw-admin/calendar")]
    #[Link("/manage", Link::GET, [], "/cmw-admin/calendar")]
    public function calendarManage(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "calendar.show");

        View::createAdminView('Calendar', 'manage')
            ->addScriptBefore("App/Package/Calendar/Views/Resources/fullcalendar.js")
            ->view();
    }

    #[NoReturn] #[Link("/manage", Link::POST, [], "/cmw-admin/calendar")]
    public function calendarPostEvent(): void
    {
        UsersController::redirectIfNotHavePermissions("calendar.edit");

        [$name, $startDate, $endDate] = Utils::filterInput('name', 'startDate', 'endDate');
        $userId = UsersModel::getCurrentUser()?->getId();

        CalendarModel::getInstance()->createEvent($name, $startDate, $endDate, $userId);

        Flash::send(Alert::SUCCESS, LangManager::translate("core.toaster.success"),"Événements ajouté !");

        Redirect::redirectPreviousRoute();
    }

    /* //////////////////// FRONT PUBLIC //////////////////// */

    #[Link('/calendar', Link::GET)]
    public function publicCalendar(): void
    {

        $view = new View('Calendar', 'main');
        $view->view();
    }
}
