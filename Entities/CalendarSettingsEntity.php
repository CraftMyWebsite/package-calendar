<?php

namespace CMW\Entity\Calendar;


use CMW\Manager\Package\AbstractEntity;
use CMW\Utils\Date;

class CalendarSettingsEntity extends AbstractEntity
{
    private ?string $calendar_settings_webhook_new_event;
    private bool $calendar_settings_use_webhook_new_event;
    private ?string $calendar_settings_locale;
    private int $calendar_settings_dayMaxEventRows;
    private int $calendar_settings_height;
    private bool $calendar_settings_use_nowIndicator;
    private ?string $calendar_settings_initialView;
    private string $calendar_settings_updated;

    /**
     * @param ?string $calendar_settings_webhook_new_event
     * @param bool $calendar_settings_use_webhook_new_event
     * @param ?string $calendar_settings_locale
     * @param int $calendar_settings_dayMaxEventRows
     * @param int $calendar_settings_height
     * @param bool $calendar_settings_use_nowIndicator
     * @param ?string $calendar_settings_initialView
     * @param bool $calendar_settings_updated
     */
    public function __construct(?string $calendar_settings_webhook_new_event, bool $calendar_settings_use_webhook_new_event, ?string $calendar_settings_locale,
                                int     $calendar_settings_dayMaxEventRows, int $calendar_settings_height, bool $calendar_settings_use_nowIndicator, ?string $calendar_settings_initialView,
                                bool    $calendar_settings_updated)
    {
        $this->calendar_settings_webhook_new_event = $calendar_settings_webhook_new_event;
        $this->calendar_settings_use_webhook_new_event = $calendar_settings_use_webhook_new_event;
        $this->calendar_settings_locale = $calendar_settings_locale;
        $this->calendar_settings_dayMaxEventRows = $calendar_settings_dayMaxEventRows;
        $this->calendar_settings_height = $calendar_settings_height;
        $this->calendar_settings_use_nowIndicator = $calendar_settings_use_nowIndicator;
        $this->calendar_settings_initialView = $calendar_settings_initialView;
        $this->calendar_settings_updated = $calendar_settings_updated;
    }

    /**
     * @return ?string
     */
    public function getWebhookNewEvent(): ?string
    {
        return $this->calendar_settings_webhook_new_event;
    }

    /**
     * @return bool
     */
    public function getUseWebhookNewEvent(): bool
    {
        return $this->calendar_settings_use_webhook_new_event;
    }

    /**
     * @return ?string
     */
    public function getLocal(): ?string
    {
        return $this->calendar_settings_locale;
    }

    /**
     * @return int
     */
    public function getDayMaxEventRows(): int
    {
        return $this->calendar_settings_dayMaxEventRows;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->calendar_settings_height;
    }

    /**
     * @return bool
     */
    public function getUseNowIndicator(): bool
    {
        return $this->calendar_settings_use_nowIndicator;
    }

    /**
     * @return ?string
     */
    public function getInitialView(): ?string
    {
        return $this->calendar_settings_initialView;
    }

    /**
     * @return string
     */
    public function getUpdated(): string
    {
        return Date::formatDate($this->calendar_settings_updated);
    }
}
