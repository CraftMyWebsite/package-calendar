<?php

namespace CMW\Implementation\Calendar\Core;

use CMW\Interface\Core\IMenus;

class CalendarMenusImplementations implements IMenus
{
    public function getRoutes(): array
    {
        return [
            'Calendrier' => 'calendar',
        ];
    }

    public function getPackageName(): string
    {
        return 'Calendar';
    }
}
