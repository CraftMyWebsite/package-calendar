<?php

namespace CMW\Controller\Calendar;

use CMW\Controller\users\UsersController;

use CMW\Controller\Users\UsersSessionsController;
use CMW\Event\Calendar\CreateEvent;
use CMW\Event\Calendar\DeleteEvent;
use CMW\Manager\Events\Emitter;
use CMW\Manager\Flash\Alert;
use CMW\Manager\Flash\Flash;
use CMW\Manager\Lang\LangManager;
use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Manager\Views\View;
use CMW\Manager\Webhook\Discord\DiscordWebhook;
use CMW\Model\Calendar\CalendarModel;
use CMW\Model\Calendar\CalendarSettingsModel;
use CMW\Utils\Redirect;
use CMW\Utils\Utils;
use CMW\Utils\Website;
use JetBrains\PhpStorm\NoReturn;

/**
 * Class: @CalendarController
 * @package Calendar
 * @author Z0mb
 * @version 0.0.1
 */
class CalendarController extends AbstractController
{
    #[Link(path: '/', method: Link::GET, scope: '/cmw-admin/calendar')]
    #[Link('/manage', Link::GET, [], '/cmw-admin/calendar')]
    private function calendarManage(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'calendar.show');

        $events = CalendarModel::getInstance()->getEvents();
        $config = CalendarSettingsModel::getInstance()->getConfig();

        View::createAdminView('Calendar', 'manage')
            ->addScriptBefore('App/Package/Calendar/Views/Resources/fullcalendar.js', 'App/Package/Calendar/Views/Resources/calendar.js')
            ->addVariableList(['events' => $events, 'config' => $config])
            ->view();
    }

    /**
     * @throws \ReflectionException
     * @throws \JsonException
     */
    #[NoReturn]
    #[Link('/manage', Link::POST, [], '/cmw-admin/calendar')]
    private function calendarPostEvent(): void
    {
        UsersController::redirectIfNotHavePermissions('calendar.edit');

        $config = CalendarSettingsModel::getInstance()->getConfig();

        [$name, $startDate, $endDate, $backgroundColor, $borderColor, $textColor] = Utils::filterInput('name', 'startDate', 'endDate', 'backgroundColor', 'borderColor', 'textColor');
        $userId = UsersSessionsController::getInstance()->getCurrentUser()?->getId();

        $calendar = CalendarModel::getInstance()->createEvent($name, $startDate, $endDate, $backgroundColor, $borderColor, $textColor, $userId);

        if ($calendar) {
            Emitter::send(CreateEvent::class, $calendar);
            if ($config->getUseWebhookNewEvent()) {
                DiscordWebhook::createWebhook($config->getWebhookNewEvent())
                    ->setImageUrl(null)
                    ->setTts(false)
                    ->setTitle($calendar->getName())
                    ->setTitleLink(Website::getUrl() . 'calendar')
                    ->setDescription(LangManager::translate('calendar.discord.desc') . $calendar->getStartDate())
                    ->setColor('35AFD9')
                    ->setFooterText(Website::getWebsiteName())
                    ->setFooterIconUrl(null)
                    ->setAuthorName(Website::getWebsiteName() . LangManager::translate('calendar.discord.newEvent'))
                    ->setAuthorUrl(null)
                    ->send();
            }

            Flash::send(Alert::SUCCESS, LangManager::translate('calendar.flash.title'), LangManager::translate('calendar.flash.eventAdded'));
        } else {
            Flash::send(Alert::ERROR, LangManager::translate('calendar.flash.title'), LangManager::translate('calendar.flash.eventError') );
        }


        Redirect::redirectPreviousRoute();
    }

    /**
     * @throws \ReflectionException
     */
    #[NoReturn]
    #[Link('/manage/delete', Link::POST, [], '/cmw-admin/calendar')]
    private function calendarDeleteEvent(): void
    {
        UsersController::redirectIfNotHavePermissions('calendar.delete');

        [$event] = Utils::filterInput('event');

        CalendarModel::getInstance()->deleteEvent($event);

        Emitter::send(DeleteEvent::class, $event);

        Flash::send(Alert::SUCCESS, LangManager::translate('calendar.flash.title'), LangManager::translate('calendar.flash.eventDeleted'));

        Redirect::redirectPreviousRoute();
    }

    #[NoReturn]
    #[Link('/manage/applySettings', Link::POST, [], '/cmw-admin/calendar')]
    private function calendarApplySettings(): void
    {
        UsersController::redirectIfNotHavePermissions('calendar.edit');

        [$calendar_settings_use_webhook_new_event, $calendar_settings_webhook_new_event, $calendar_settings_locale, $calendar_settings_use_nowIndicator, $calendar_settings_initialView, $calendar_settings_dayMaxEventRows, $calendar_settings_height] = Utils::filterInput('calendar_settings_use_webhook_new_event', 'calendar_settings_webhook_new_event', 'calendar_settings_locale', 'calendar_settings_use_nowIndicator', 'calendar_settings_initialView', 'calendar_settings_dayMaxEventRows', 'calendar_settings_height');

        CalendarSettingsModel::getInstance()->updateConfig($calendar_settings_webhook_new_event === '' ? null : $calendar_settings_webhook_new_event,
            $calendar_settings_use_webhook_new_event === NULL ? 0 : 1, $calendar_settings_locale, $calendar_settings_dayMaxEventRows, $calendar_settings_height, $calendar_settings_use_nowIndicator === NULL ? 0 : 1, $calendar_settings_initialView);

        Flash::send(Alert::SUCCESS, LangManager::translate('calendar.flash.title'), LangManager::translate('calendar.flash.settingApply'));

        Redirect::redirectPreviousRoute();
    }

    /* //////////////////// FRONT PUBLIC //////////////////// */

    #[Link('/calendar', Link::GET)]
    private function publicCalendar(): void
    {
        View::createPublicView('Calendar', 'main')
            ->addScriptBefore('App/Package/Calendar/Views/Resources/fullcalendar.js', 'App/Package/Calendar/Views/Resources/calendar.js')
            ->view();
    }
}
