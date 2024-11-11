<?php

namespace CMW\Entity\Calendar;

use CMW\Entity\Users\UserEntity;
use CMW\Manager\Package\AbstractEntity;
use CMW\Utils\Date;

class CalendarEntity extends AbstractEntity
{
    private int $id;
    private string $name;
    private string $startDate;
    private string $endDate;
    private string $backgroundColor;
    private string $borderColor;
    private string $textColor;
    private UserEntity $author;

    /**
     * @param int $id
     * @param string $name
     * @param string $startDate
     * @param string $endDate
     * @param string $backgroundColor
     * @param string $borderColor
     * @param string $textColor
     * @param UserEntity $author
     */
    public function __construct(int $id, string $name, string $startDate, string $endDate, string $backgroundColor, string $borderColor, string $textColor, UserEntity $author)
    {
        $this->id = $id;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->backgroundColor = $backgroundColor;
        $this->borderColor = $borderColor;
        $this->textColor = $textColor;
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
        return Date::formatDate($this->startDate);
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return Date::formatDate($this->endDate);
    }

    /**
     * @return string
     */
    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    /**
     * @return string
     */
    public function getBorderColor(): string
    {
        return $this->borderColor;
    }

    /**
     * @return string
     */
    public function getTextColor(): string
    {
        return $this->textColor;
    }

    /**
     * @return UserEntity
     */
    public function getAuthor(): UserEntity
    {
        return $this->author;
    }
}
