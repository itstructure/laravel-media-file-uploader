<?php

namespace Itstructure\MFU\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Uploader
 * @package Itstructure\MFU\Facades
 */
class Uploader extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uploader';
    }
}
