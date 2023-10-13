<?php

namespace CMW\Implementation\Calendar;

use CMW\Interface\Core\IMenus;
use CMW\Manager\Lang\LangManager;

class CalendarMenusImplementations implements IMenus {

    public function getRoutes(): array
    {
        return [
            "Calendrier" => 'calendar'
        ];
    }

    public function getPackageName(): string
    {
        return 'Calendar';
    }
}