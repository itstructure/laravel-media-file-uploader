<?php

namespace Itstructure\MFU\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Itstructure\MFU\Facades\{Uploader, Previewer};
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
     * @throws HttpException
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
            return abort(400, $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws HttpException
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
            return abort(400, $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws HttpException
     */
    public function delete(Request $request)
    {
        try {
            return response()->json([
                'success' => Uploader::delete($request->post('id'))
            ]);

        } catch (Throwable $exception) {
            return abort(400, $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return string
     * @throws HttpException
     */
    public function preview(Request $request)
    {
        try {
            $id = $request->post('id');
            $location = $request->post('location') ?? \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO;
            $mediaFile = Mediafile::find($id);
            return Previewer::getPreviewHtml($mediaFile, $location);

        } catch (Throwable $exception) {
            return abort(400, $exception->getMessage());
        }
    }
}
