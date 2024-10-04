<?php
namespace CMW\Event\Calendar;

use CMW\Manager\Events\AbstractEvent;

class DeleteEvent extends AbstractEvent
{
    public function getName(): string
    {
        return 'DeleteEvent-Calendar-CraftMyWebsite';
    }
}
