<?php

namespace Itstructure\MFU\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Itstructure\MFU\Facades\Uploader;
use Itstructure\MFU\Facades\Previewer;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class UploadController
 * @package Itstructure\MFU\Http\Controllers
 */
class UploadController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        try {
            $data = $request->post('data');
            $file = $request->file('file');

            if (!Uploader::upload($data, $file)) {
                return response()->json([
                    'success' => false,
                    'errors' => Uploader::hasErrors()
                        ? Uploader::getErrors()->getMessages()
                        : []
                ]);
            }
            return response()->json([
                'success' => true,
                'id' => Uploader::getId()
            ]);

        } catch (Throwable $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $id = $request->post('id');
            $data = $request->post('data');
            $file = $request->hasFile('file') ? $request->file('file') : null;

            if (!Uploader::update($id, $data, $file)) {
                return response()->json([
                    'success' => false,
                    'errors' => Uploader::hasErrors()
                        ? Uploader::getErrors()->getMessages()
                        : []
                ]);
            }
            return response()->json([
                'success' => true
            ]);

        } catch (Throwable $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->post('id');

            if (!Uploader::delete($id)) {
                return response()->json([
                    'success' => false
                ]);
            }
            return response()->json([
                'success' => true
            ]);

        } catch (Throwable $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function preview(Request $request)
    {
        try {
            $id = $request->post('id');
            $location = $request->post('location') ?? \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO;
            $mediaFile = Mediafile::find($id);
            return Previewer::getPreviewHtml($mediaFile, $location);

        } catch (Throwable $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }
}
