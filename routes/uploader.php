<?php

use Illuminate\Support\Facades\Route;
use Itstructure\MFU\Http\Controllers\{
    UploadController, DownloadController
};
use Itstructure\MFU\Http\Controllers\Managers\{
    FileListManagerController, FileUploadManagerController, FileEditManagerController
};
use Itstructure\MFU\Http\Controllers\Albums\{
    ImageAlbumController, AudioAlbumController, VideoAlbumController, AppAlbumController,
    TextAlbumController, OtherAlbumController
};
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Models\Albums\Album;

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
        Route::post('upload', [UploadController::class, 'upload'])->name('uploader_file_upload');
        Route::post('update', [UploadController::class, 'update'])->name('uploader_file_update');
        Route::post('delete', [UploadController::class, 'delete'])->name('uploader_file_delete');
        Route::get('download/{id}', [DownloadController::class, 'download'])->name('uploader_file_download')->where('id','\d+');
        Route::post('preview', [UploadController::class, 'preview'])->name('uploader_file_preview');
    });


    /* MANAGERS */
    Route::group(['prefix' => 'managers'], function () {
        Route::get('file-list', [FileListManagerController::class, 'index'])->name('uploader_file_list_manager');
        Route::get('file-upload', [FileUploadManagerController::class, 'index'])->name('uploader_file_upload_manager');
        Route::get('file-edit/{id}', [FileEditManagerController::class, 'index'])->name('uploader_file_edit_manager');
        Route::post('file-list/delete', [FileListManagerController::class, 'delete'])->name('uploader_file_list_delete');
    });

    /* MANAGERS */
    Route::group(['prefix' => 'albums'], function () {
        Route::group(['prefix' => SaveProcessor::FILE_TYPE_IMAGE], function () {
            Route::get('list', [ImageAlbumController::class, 'index'])->name('uploader_' . Album::ALBUM_TYPE_IMAGE . '_list');
            Route::get('create', [ImageAlbumController::class, 'create'])->name('uploader_' . Album::ALBUM_TYPE_IMAGE . '_create');
            Route::post('store', [ImageAlbumController::class, 'store'])->name('uploader_' . Album::ALBUM_TYPE_IMAGE . '_store');
            Route::get('edit/{id}', [ImageAlbumController::class, 'edit'])->name('uploader_' . Album::ALBUM_TYPE_IMAGE . '_edit')->where('id','\d+');
            Route::post('update/{id}', [ImageAlbumController::class, 'update'])->name('uploader_' . Album::ALBUM_TYPE_IMAGE . '_update')->where('id','\d+');
            Route::post('delete', [ImageAlbumController::class, 'delete'])->name('uploader_' . Album::ALBUM_TYPE_IMAGE . '_delete');
            Route::get('view/{id}', [ImageAlbumController::class, 'view'])->name('uploader_' . Album::ALBUM_TYPE_IMAGE . '_view')->where('id','\d+');
        });
        Route::group(['prefix' => SaveProcessor::FILE_TYPE_AUDIO], function () {
            Route::get('list', [AudioAlbumController::class, 'index'])->name('uploader_' . Album::ALBUM_TYPE_AUDIO . '_list');
            Route::get('create', [AudioAlbumController::class, 'create'])->name('uploader_' . Album::ALBUM_TYPE_AUDIO . '_create');
            Route::post('store', [AudioAlbumController::class, 'store'])->name('uploader_' . Album::ALBUM_TYPE_AUDIO . '_store');
            Route::get('edit/{id}', [AudioAlbumController::class, 'edit'])->name('uploader_' . Album::ALBUM_TYPE_AUDIO . '_edit')->where('id','\d+');
            Route::post('update/{id}', [AudioAlbumController::class, 'update'])->name('uploader_' . Album::ALBUM_TYPE_AUDIO . '_update')->where('id','\d+');
            Route::post('delete', [AudioAlbumController::class, 'delete'])->name('uploader_' . Album::ALBUM_TYPE_AUDIO . '_delete');
            Route::get('view/{id}', [AudioAlbumController::class, 'view'])->name('uploader_' . Album::ALBUM_TYPE_AUDIO . '_view')->where('id','\d+');
        });
        Route::group(['prefix' => SaveProcessor::FILE_TYPE_VIDEO], function () {
            Route::get('list', [VideoAlbumController::class, 'index'])->name('uploader_' . Album::ALBUM_TYPE_VIDEO . '_list');
            Route::get('create', [VideoAlbumController::class, 'create'])->name('uploader_' . Album::ALBUM_TYPE_VIDEO . '_create');
            Route::post('store', [VideoAlbumController::class, 'store'])->name('uploader_' . Album::ALBUM_TYPE_VIDEO . '_store');
            Route::get('edit/{id}', [VideoAlbumController::class, 'edit'])->name('uploader_' . Album::ALBUM_TYPE_VIDEO . '_edit')->where('id','\d+');
            Route::post('update/{id}', [VideoAlbumController::class, 'update'])->name('uploader_' . Album::ALBUM_TYPE_VIDEO . '_update')->where('id','\d+');
            Route::post('delete', [VideoAlbumController::class, 'delete'])->name('uploader_' . Album::ALBUM_TYPE_VIDEO . '_delete');
            Route::get('view/{id}', [VideoAlbumController::class, 'view'])->name('uploader_' . Album::ALBUM_TYPE_VIDEO . '_view')->where('id','\d+');
        });
        Route::group(['prefix' => SaveProcessor::FILE_TYPE_APP], function () {
            Route::get('list', [AppAlbumController::class, 'index'])->name('uploader_' . Album::ALBUM_TYPE_APP . '_list');
            Route::get('create', [AppAlbumController::class, 'create'])->name('uploader_' . Album::ALBUM_TYPE_APP . '_create');
            Route::post('store', [AppAlbumController::class, 'store'])->name('uploader_' . Album::ALBUM_TYPE_APP . '_store');
            Route::get('edit/{id}', [AppAlbumController::class, 'edit'])->name('uploader_' . Album::ALBUM_TYPE_APP . '_edit')->where('id','\d+');
            Route::post('update/{id}', [AppAlbumController::class, 'update'])->name('uploader_' . Album::ALBUM_TYPE_APP . '_update')->where('id','\d+');
            Route::post('delete', [AppAlbumController::class, 'delete'])->name('uploader_' . Album::ALBUM_TYPE_APP . '_delete');
            Route::get('view/{id}', [AppAlbumController::class, 'view'])->name('uploader_' . Album::ALBUM_TYPE_APP . '_view')->where('id','\d+');
        });
        Route::group(['prefix' => SaveProcessor::FILE_TYPE_TEXT], function () {
            Route::get('list', [TextAlbumController::class, 'index'])->name('uploader_' . Album::ALBUM_TYPE_TEXT . '_list');
            Route::get('create', [TextAlbumController::class, 'create'])->name('uploader_' . Album::ALBUM_TYPE_TEXT . '_create');
            Route::post('store', [TextAlbumController::class, 'store'])->name('uploader_' . Album::ALBUM_TYPE_TEXT . '_store');
            Route::get('edit/{id}', [TextAlbumController::class, 'edit'])->name('uploader_' . Album::ALBUM_TYPE_TEXT . '_edit')->where('id','\d+');
            Route::post('update/{id}', [TextAlbumController::class, 'update'])->name('uploader_' . Album::ALBUM_TYPE_TEXT . '_update')->where('id','\d+');
            Route::post('delete', [TextAlbumController::class, 'delete'])->name('uploader_' . Album::ALBUM_TYPE_TEXT . '_delete');
            Route::get('view/{id}', [TextAlbumController::class, 'view'])->name('uploader_' . Album::ALBUM_TYPE_TEXT . '_view')->where('id','\d+');
        });
        Route::group(['prefix' => SaveProcessor::FILE_TYPE_OTHER], function () {
            Route::get('list', [OtherAlbumController::class, 'index'])->name('uploader_' . Album::ALBUM_TYPE_OTHER . '_list');
            Route::get('create', [OtherAlbumController::class, 'create'])->name('uploader_' . Album::ALBUM_TYPE_OTHER . '_create');
            Route::post('store', [OtherAlbumController::class, 'store'])->name('uploader_' . Album::ALBUM_TYPE_OTHER . '_store');
            Route::get('edit/{id}', [OtherAlbumController::class, 'edit'])->name('uploader_' . Album::ALBUM_TYPE_OTHER . '_edit')->where('id','\d+');
            Route::post('update/{id}', [OtherAlbumController::class, 'update'])->name('uploader_' . Album::ALBUM_TYPE_OTHER . '_update')->where('id','\d+');
            Route::post('delete', [OtherAlbumController::class, 'delete'])->name('uploader_' . Album::ALBUM_TYPE_OTHER . '_delete');
            Route::get('view/{id}', [OtherAlbumController::class, 'view'])->name('uploader_' . Album::ALBUM_TYPE_OTHER . '_view')->where('id','\d+');
        });
    });
});
