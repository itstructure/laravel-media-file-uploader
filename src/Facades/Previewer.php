<?php

namespace Itstructure\MFU\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Previewer
 * @package Itstructure\MFU\Facades
 */
class Previewer extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'previewer';
    }
}
