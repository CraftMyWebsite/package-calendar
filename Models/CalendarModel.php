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
        $sql = 'SELECT calendar_id FROM cmw_calendar';
        $db = DatabaseManager::getInstance();

        $res = $db->prepare($sql);

        if (!$res->execute()) {
            return array();
        }

        $toReturn = array();

        while ($event = $res->fetch()) {
            $toReturn[] = $this->getEventsById($event['calendar_id']);
        }

        return $toReturn;
    }

    /**
     * @return string
     */
    public function getJsonEvents(): string
    {
        $sql = 'SELECT calendar_name AS title, calendar_startDate AS start, calendar_endDate AS end, calendar_backgroundColor AS backgroundColor, calendar_borderColor AS borderColor, calendar_textColor AS textColor FROM cmw_calendar';
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
        $sql = 'SELECT * FROM cmw_calendar WHERE calendar_id=:calendar_id';

        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute(array('calendar_id' => $calendarId))) {
            return null;
        }

        $res = $res->fetch();

        $user = UsersModel::getInstance()->getUserById($res['user_id']);

        return new CalendarEntity(
            $res['calendar_id'],
            $res['calendar_name'],
            $res['calendar_startDate'],
            $res['calendar_endDate'],
            $res['calendar_backgroundColor'],
            $res['calendar_borderColor'],
            $res['calendar_textColor'],
            $user
        );
    }

    /**
     * @param string $name
     * @param string $startDate
     * @param string $endDate
     * @param string $backgroundColor
     * @param string $borderColor
     * @param string $textColor
     * @param int $author
     * @return CalendarEntity|null
     */
    public function createEvent(string $name, string $startDate, string $endDate, string $backgroundColor, string $borderColor, string $textColor, int $author): ?CalendarEntity
    {
        $var = array(
            'name' => $name,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor,
            'textColor' => $textColor,
            'author' => $author
        );

        $sql = 'INSERT INTO cmw_calendar (calendar_name, calendar_startDate, calendar_endDate,calendar_backgroundColor, calendar_borderColor, calendar_textColor, user_id) VALUES (:name, :startDate, :endDate, :backgroundColor, :borderColor, :textColor, :author)';

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $id = $db->lastInsertId();
            return $this->getEventsById($id);
        }

        return null;
    }

    /**
     * @param string $enventId
     */
    public function deleteEvent(int $enventId): void
    {
        $sql = 'DELETE FROM cmw_calendar WHERE calendar_id = :id';
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);
        $req->execute(array('id' => $enventId));
    }
}
