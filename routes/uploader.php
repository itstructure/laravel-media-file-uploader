<?php

use Illuminate\Support\Facades\Route;
use Itstructure\MFU\Http\Controllers\{
    UploadController, DownloadController
};
use Itstructure\MFU\Http\Controllers\Managers\{
    FileListManagerController, FileUploadManagerController, FileEditManagerController
};

Route::group([
        'prefix' => 'uploader',
        'middleware' => array_merge(
            !empty(config('uploader.routing')) && is_array(config('uploader.routing.middlewares'))
                ? config('uploader.routing.middlewares')
                : []
        )
    ], function () {


    /* UPLOADING */
    Route::group(['prefix' => 'file'], function () {

        Route::post('upload', [UploadController::class, 'upload'])
            ->name('uploader_file_upload');

        Route::post('update', [UploadController::class, 'update'])
            ->name('uploader_file_update');

        Route::post('delete', [UploadController::class, 'delete'])
            ->name('uploader_file_delete');

        Route::get('download', [DownloadController::class, 'download'])
            ->name('uploader_file_download');
    });


    /* MANAGERS */
    Route::group(['prefix' => 'managers'], function () {

        Route::get('file-list', [FileListManagerController::class, 'index'])
            ->name('uploader_file_list_manager');

        Route::get('file-upload', [FileUploadManagerController::class, 'index'])
            ->name('uploader_file_upload_manager');

        Route::get('file-edit/{id}', [FileEditManagerController::class, 'index'])
            ->name('uploader_file_edit_manager');
    });
});
