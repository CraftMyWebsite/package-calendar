<?php

namespace CMW\Model\Calendar;

use CMW\Entity\Calendar\CalendarEntity;
use CMW\Manager\Database\DatabaseManager;

use CMW\Manager\Package\AbstractModel;
use CMW\Model\Users\UsersModel;

/**
 * Class @CalendarModel
 * @package Calendar
 * @author Z0mb
 * @version 0.0.1
 */
class CalendarModel extends AbstractModel
{
    /**
     * @return CalendarEntity[]
     */
    public function getEvents(): array
    {
        $sql = "SELECT calendar_id FROM cmw_calendar";
        $db = DatabaseManager::getInstance();

        $res = $db->prepare($sql);

        if (!$res->execute()) {
            return array();
        }

        $toReturn = array();

        while ($event = $res->fetch()) {
            $toReturn[] = $this->getEventsById($event["calendar_id"]);
        }

        return $toReturn;
    }

    /**
     * @return string
     */
    public function getJsonEvents(): string
    {
        $sql = "SELECT calendar_name AS title, calendar_startDate AS start, calendar_endDate AS end FROM cmw_calendar";
        $db = DatabaseManager::getInstance();

        $res = $db->prepare($sql);

        $res->execute();
        $event = $res->fetchAll();
        return json_encode($event);
    }

    /**
     * @param $calendarId
     * @return CalendarEntity|null
     */
    public function getEventsById($calendarId): ?CalendarEntity
    {

        $sql = "SELECT * FROM cmw_calendar WHERE calendar_id=:calendar_id";

        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);


        if (!$res->execute(array("calendar_id" => $calendarId))) {
            return null;
        }

        $res = $res->fetch();

        $user = UsersModel::getInstance()->getUserById($res["user_id"]);

        return new CalendarEntity(
            $res['calendar_id'],
            $res['calendar_name'],
            $res['calendar_startDate'],
            $res['calendar_endDate'],
            $user
        );
    }

    /**
     * @param string $name
     * @param string $startDate
     * @param string $endDate
     * @param int $author
     * @return CalendarEntity|null
     */
    public function createEvent(string $name, string $startDate, string $endDate, int $author): ?CalendarEntity
    {
        $var = array(
            'name' => $name,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'author' => $author
        );

        $sql = "INSERT INTO cmw_calendar (calendar_name, calendar_startDate, calendar_endDate, user_id) VALUES (:name, :startDate, :endDate, :author)";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $id = $db->lastInsertId();
            return $this->getEventsById($id);
        }

        return null;
    }

}
