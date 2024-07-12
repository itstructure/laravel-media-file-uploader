<?php

namespace Itstructure\MFU\Traits;

use Itstructure\MFU\Models\Owners\OwnerMediafile;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class Thumbnailable
 * @method string getItsName()
 * @method int getPrimaryKey()
 * @package Itstructure\MFU\Traits
 */
trait Thumbnailable
{
    public function getThumbnailModel(): ?Mediafile
    {
        return OwnerMediafile::getOwnerThumbnailModel($this->getItsName(), $this->getPrimaryKey());
    }
}
