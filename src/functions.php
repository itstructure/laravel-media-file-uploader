<?php

use Itstructure\MFU\Views\FileSetter;

/**
 * @param array $config
 * @return string
 */
function file_setter(array $config)
{
    return FileSetter::getInstance($config)->render();
}
