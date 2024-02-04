<?php

namespace Itstructure\MFU\Http\Controllers\Managers;

use Illuminate\Http\Request;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Itstructure\MFU\Http\Controllers\BaseController;
use Itstructure\MFU\Models\{OwnerMediafile, Mediafile};

/**
 * Class FileManagerController
 * @package Itstructure\MFU\Http\Controllers\Managers
 */
class FileManagerController extends BaseController
{
    public function index(Request $request)
    {
        $requestParams = [];

        if ((null !== $request->get('owner_name') && null !== $request->get('owner_id'))) {
            $requestParams['owner_name'] = $request->get('owner_name');
            $requestParams['owner_id'] = $request->get('owner_id');
        }

        if (null !== $request->get('owner_attribute')) {
            $requestParams['owner_attribute'] = $request->get('owner_attribute');
        }

        if (count($requestParams) > 0) {
            $query = OwnerMediafile::getMediaFilesQuery($requestParams)->orWhereNotIn('mediafile_id', OwnerMediafile::pluck('mediafile_id')->toArray());
        } else {
            $query = Mediafile::whereNotIn('mediafile_id', OwnerMediafile::pluck('mediafile_id')->toArray());
        }

        return view('uploader::managers.file-manager', [
            'dataProvider' => new EloquentDataProvider($query)
        ]);
    }
}
