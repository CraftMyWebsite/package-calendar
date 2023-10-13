<?php

namespace CMW\Entity\Calendar;

use CMW\Entity\Users\UserEntity;

class CalendarEntity
{

    private int $id;
    private string $name;
    private string $startDate;
    private string $endDate;
    private UserEntity $author;

    /**
     * @param int $id
     * @param string $name
     * @param string $startDate
     * @param string $endDate
     * @param UserEntity $author
     */
    public function __construct(int $id, string $name, string $startDate, string $endDate, UserEntity $author)
    {
        $this->id = $id;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @return UserEntity
     */
    public function getAuthor(): UserEntity
    {
        return $this->author;
    }

}