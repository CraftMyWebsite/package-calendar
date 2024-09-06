<?php

namespace CMW\Controller\Calendar;

use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Model\Calendar\CalendarModel;
use CMW\Model\Calendar\CalendarSettingsModel;

/**
 * Class: @CalendarAPIController
 * @package Calendar
 * @author Z0mb
 * @version 0.0.1
 */
class CalendarAPIController extends AbstractController
{
    #[Link('/data', Link::GET, [], '/api/calendar')]
    public function calendarGetData(): void
    {
        $returnData = [];
        $returnData['events'] = CalendarModel::getInstance()->getJsonEvents();  // is json encoded
        $returnData['settings'] = CalendarSettingsModel::getInstance()->getSettingsData();
        echo json_encode($returnData);
    }
}
