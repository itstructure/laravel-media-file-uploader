<?php

namespace Itstructure\MFU\Http\Controllers\Managers;

use Throwable;
use Illuminate\Http\Request;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Itstructure\MFU\Http\Controllers\BaseController;
use Itstructure\MFU\Models\{OwnerMediafile, Mediafile};
use Itstructure\MFU\Facades\Uploader;

/**
 * Class FileListManagerController
 * @package Itstructure\MFU\Http\Controllers\Managers
 */
class FileListManagerController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

        return view('uploader::managers.file-list', [
            'dataProvider' => new EloquentDataProvider($query),
            'manager' => 'file_list'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        foreach ($request->items ?? [] as $id) {
            try {
                Uploader::delete($id);
            } catch (Throwable $e) {}
        }

        return back();
    }
}
