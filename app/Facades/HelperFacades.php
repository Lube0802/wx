<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class HelperFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "Helper";
    }
}