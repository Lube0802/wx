<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class QrCodeFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "QrCode";
    }
}
