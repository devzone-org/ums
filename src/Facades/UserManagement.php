<?php

namespace Devzone\UserManagement\Facades;

use Illuminate\Support\Facades\Facade;

class UserManagement extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'user-management';
    }
}
