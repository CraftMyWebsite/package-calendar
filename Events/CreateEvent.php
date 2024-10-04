<?php
namespace CMW\Event\Calendar;

use CMW\Manager\Events\AbstractEvent;

class CreateEvent extends AbstractEvent
{
    public function getName(): string
    {
        return 'CreateEvent-Calendar-CraftMyWebsite';
    }
}
