<?php

namespace CMW\Model\Calendar;

use CMW\Entity\Calendar\CalendarSettingsEntity;
use CMW\Entity\Support\SupportSettingEntity;
use CMW\Manager\Database\DatabaseManager;
use CMW\Manager\Package\AbstractModel;



/**
 * Class @CalendarSettingsModel
 * @package Calendar
 * @author Zomb
 * @version 0.0.1
 */
class CalendarSettingsModel extends AbstractModel
{
    public function getConfig(): ?CalendarSettingsEntity
    {
        $sql = "SELECT * FROM cmw_calendar_settings LIMIT 1";

        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);


        if (!$res->execute()) {
            return null;
        }

        $res = $res->fetch();

        return new CalendarSettingsEntity(
            $res['calendar_settings_webhook_new_event'] ?? null,
            $res['calendar_settings_use_webhook_new_event'],
            $res['calendar_settings_locale'] ?? null,
            $res['calendar_settings_dayMaxEventRows'],
            $res['calendar_settings_height'],
            $res['calendar_settings_use_nowIndicator'],
            $res['calendar_settings_initialView'] ?? null,
            $res['calendar_settings_updated']
        );
    }

    public function updateConfig(?string $calendar_settings_webhook_new_event,int $calendar_settings_use_webhook_new_event, ?string $calendar_settings_locale,int $calendar_settings_dayMaxEventRows,int $calendar_settings_height, int $calendar_settings_use_nowIndicator,?string $calendar_settings_initialView): ?CalendarSettingsEntity
    {
        $info = array(
            "calendar_settings_webhook_new_event" => $calendar_settings_webhook_new_event,
            "calendar_settings_use_webhook_new_event" => $calendar_settings_use_webhook_new_event,
            "calendar_settings_locale" => $calendar_settings_locale,
            "calendar_settings_dayMaxEventRows" => $calendar_settings_dayMaxEventRows,
            "calendar_settings_height" => $calendar_settings_height,
            "calendar_settings_use_nowIndicator" => $calendar_settings_use_nowIndicator,
            "calendar_settings_initialView" => $calendar_settings_initialView,
        );

        $sql = "UPDATE cmw_calendar_settings SET calendar_settings_webhook_new_event = :calendar_settings_webhook_new_event,calendar_settings_use_webhook_new_event = :calendar_settings_use_webhook_new_event, calendar_settings_locale= :calendar_settings_locale, calendar_settings_dayMaxEventRows= :calendar_settings_dayMaxEventRows, calendar_settings_height= :calendar_settings_height,calendar_settings_use_nowIndicator= :calendar_settings_use_nowIndicator,calendar_settings_initialView= :calendar_settings_initialView";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);
        if ($req->execute($info)) {
            return $this->getConfig();
        }

        return null;
    }

    /**
     * @return string
     */
    public function getSettingsData(): string
    {
        $sql = "SELECT calendar_settings_locale AS locale, calendar_settings_dayMaxEventRows AS dayMaxEventRows, calendar_settings_height AS height, calendar_settings_use_nowIndicator AS useNowIndicator, calendar_settings_initialView AS initialView FROM cmw_calendar_settings";
        $db = DatabaseManager::getInstance();

        $res = $db->prepare($sql);

        $res->execute();
        $event = $res->fetchAll();
        return json_encode($event);
    }
}
