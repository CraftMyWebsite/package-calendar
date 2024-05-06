<?php

namespace CMW\Permissions\Calendar;

use CMW\Manager\Lang\LangManager;
use CMW\Manager\Permission\IPermissionInit;
use CMW\Manager\Permission\PermissionInitType;

class Permissions implements IPermissionInit
{
    public function permissions(): array
    {
        return [
            new PermissionInitType(
                code: 'calendar.show',
                description: LangManager::translate('calendar.permissions.calendar.show'),
            ),
            new PermissionInitType(
                code: 'calendar.edit',
                description: LangManager::translate('calendar.permissions.calendar.edit'),
            ),
            new PermissionInitType(
                code: 'calendar.create',
                description: LangManager::translate('calendar.permissions.calendar.create'),
            ),
            new PermissionInitType(
                code: 'calendar.delete',
                description: LangManager::translate('calendar.permissions.calendar.delete'),
            ),
        ];
    }

}