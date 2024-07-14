# Laravel Media File Uploader - MFU

[![Latest Stable Version](https://poser.pugx.org/itstructure/laravel-media-file-uploader/v/stable)](https://packagist.org/packages/itstructure/laravel-media-file-uploader)
[![Latest Unstable Version](https://poser.pugx.org/itstructure/laravel-media-file-uploader/v/unstable)](https://packagist.org/packages/itstructure/laravel-media-file-uploader)
[![License](https://poser.pugx.org/itstructure/laravel-media-file-uploader/license)](https://packagist.org/packages/itstructure/laravel-media-file-uploader)
[![Total Downloads](https://poser.pugx.org/itstructure/laravel-media-file-uploader/downloads)](https://packagist.org/packages/itstructure/laravel-media-file-uploader)
[![Build Status](https://scrutinizer-ci.com/g/itstructure/laravel-media-file-uploader/badges/build.png?b=main)](https://scrutinizer-ci.com/g/itstructure/laravel-media-file-uploader/build-status/main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/itstructure/laravel-media-file-uploader/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/itstructure/laravel-media-file-uploader/?branch=main)

## 1 Introduction

This package is to upload different media files to Local or remote Amazon S3 storage.

![MFU logotip](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_logotip.png)

## 2 Requirements
- laravel 6+ | 7+ | 8+ | 9+ | 10+ | 11+
- Bootstrap 4 for styling
- JQuery
- php >= 7.2.5
- composer
- One of the next php extensions: GD|Imagick|Gmagick

## 3 Installation

### 3.1 Install package

#### General from remote Packagist repository

Run the composer command:

`composer require itstructure/laravel-media-file-uploader "~1.0.2"`

#### If you are testing this package from a local server directory

In application `composer.json` file set the repository, as in example:

```json
"repositories": [
    {
        "type": "path",
        "url": "../laravel-media-file-uploader",
        "options": {
            "symlink": true
        }
    }
],
```

Here,

**../laravel-media-file-uploader** - directory path, which has the same directory level as application and contains MFU package.

Then run command:

`composer require itstructure/laravel-media-file-uploader:dev-main --prefer-source`

### 3.3 Publish files - Required part
    
- To publish config run command:

    `php artisan uploader:publish --only=config`
    
    It stores config file to `config` folder.
    
    Else you can use `--force` argument to rewrite already published file.
    
- To publish migrations run command:
            
    `php artisan uploader:publish --only=migrations`
    
    It stores migration files to `database/migrations` folder.
    
    Else you can use `--force` argument to rewrite already published files.

- To publish assets (js and css) run command:

    `php artisan uploader:publish --only=assets`
    
    It stores js and css files to `public/vendor/uploader` folder.
    
    Else you can use `--force` argument to rewrite already published files.

### 3.4 Publish files - Custom part

- To publish views run command:

    `php artisan uploader:publish --only=views`
    
    It stores view files to `resources/views/vendor/uploader` folder.
    
    Else you can use `--force` argument to rewrite already published file.
    
- To publish translations run command:
                
    `php artisan uploader:publish --only=lang`
    
    It stores translation files to `resources/lang/vendor/uploader` folder.
    
    Else you can use `--force` argument to rewrite already published file.

### 3.5 Publish files - All parts if needed
    
- To publish all parts run command without `only` argument:

    `php artisan uploader:publish`
    
    Else you can use `--force` argument to rewrite already published files.

### 3.6 Run migrations

- Run command:

`php artisan migrate`

## 4 Configure

### 4.1 Set default filesystem disk

In a config file `filesystems.php` set the next custom settings (set default disk which you wish) and create needed base upload folder:

```php
'default' => env('FILESYSTEM_DISK', 'local'),

'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app/uploads'),
        'throw' => false,
        'url' => env('APP_URL') . '/storage/',
    ],
    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        'throw' => false,
    ],
],

'links' => [
    public_path('storage') => storage_path('app/uploads'),
],
```

Run command to create symbolic links:

`php artisan storage:link`

### 4.2 Set assets

**Pay Attention! This option is needed just in the next cases:**

- If you use a **File setter** in your app html forms (see **5.3 Digging deeper** / **5.3.3 Use FileSetter** point).

- If you use an **Album editor** (see in **5.1 Routes part**).

**Make sure** you use a **Bootstrap 4** for styling and **JQuery** in your application.

#### 4.2.1 Custom body layout case

So, set the next css assets between `head` tags of your app layout:
```html
<link rel="stylesheet" href="{{ asset('vendor/uploader/css/modal.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/uploader/css/file-area.css') }}">
```

Set the next js asset at the end of the `body` tag of your app layout:
```html
<script src="{{ asset('vendor/uploader/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/uploader/js/file-setter.js') }}"></script>
```

Note: `vendor/uploader/js/jquery.min.js` is required just if **JQuery** is absent in your application.

#### 4.2.2 If you use [AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE) package in your project

```php
'plugins' => [
    'Uploader' => [
        'active' => true,
        'files' => [
            [
                'type' => 'css',
                'asset' => true,
                'location' => '/vendor/uploader/css/modal.css',
            ],
            [
                'type' => 'css',
                'asset' => true,
                'location' => '/vendor/uploader/css/file-area.css',
            ],
            [
                'type' => 'js',
                'asset' => true,
                'location' => '/vendor/uploader/js/file-setter.js',
            ],
        ],
    ],
]
```

Pay attention: Not recommended using of `asset()` in AdminLTE config file, because it may cause an error with **UrlGenerator.php** when you will run fore example `composer install` later.

### 4.3 Change `uploader.php` config file.

This file is **intuitive**.

But at this stage, pay attention to the next important options:

- Routing middlewares. By default it is empty array, you can set for example like this:

    ```php
    'routing' => [
        'middlewares' => ['auth'],
    ],
    ```
    
    This middlewares will be applied in the `routes/uploader.php`.

- Albums layout (**Needed if you use Album editor**). By default it is empty string, you can set for example like this:

    ```php
    'albums' => [
        'layout' => 'adminlte::page', // In case if you use AdminLTE. Or you can set your special layout.
    ],
    ```

## 5 Usage

### 5.1 Routes part

There are already integrated base MFU routes to manage **files** and **albums**. See in `routes/uploader.php` package file.

The next routes are available by default:

- **Uploading section**

    For GET request method

    - `http://example-domain.com/uploader/file/download/{id}` (Name: **uploader_file_download**)

    For POST request method

    - `http://example-domain.com/uploader/file/upload` (Name: **uploader_file_upload**)
        - Required request field is **file**.
        - Optional/required request meta data fields: **[data]alt**, **[data]title**, **[data]description**, **[data]owner_id**, **[data]owner_name**, **[data]owner_attribute**, **[data]needed_file_type**, **[data]sub_dir**.
        
    - `http://example-domain.com/uploader/file/update` (Name: **uploader_file_update**)
        - Required request field is **id**.
        - Optional request field is **file**.
        - Optional/required request meta data fields: **[data]alt**, **[data]title**, **[data]description**, **[data]needed_file_type**, **[data]sub_dir**.
        
    - `http://example-domain.com/uploader/file/delete` (Name: **uploader_file_delete**)
        - Required request field is **id**.
        
    - `http://example-domain.com/uploader/file/preview` (Name: **uploader_file_preview**)
        - Required request field is **id**.
        - Optional request field is **location**. See more for **preview** option in config `uploader.php` (there are some html attributes for concrete file types and their previews). If not set, returned preview will be with html attributes according with `Previewer::LOCATION_FILE_INFO`.
        Also if it is an image, `Previewer` will return an image with sizes, according with **thumbAlias** option in config. If **thumbAlias** is not set or there is no such location, `Previewer` will return image with sizes according with `SaveProcessor::THUMB_ALIAS_SMALL`.

    Notes:
    - If uploading file is an **image**, then additional thumbnails will be created according with their settings in **thumbSizes** config option.
    - Requirement/optionality for request meta data fields is set in **metaDataValidationRules** option of config `uploader.php` file.
    - If **checkExtensionByFileType** option is **true**, then **[data]needed_file_type** is required automatically.
    
- **Managing section**

    For GET request method

    - `http://example-domain.com/uploader/managers/file-list` (Name: **uploader_file_list_manager**)
    - `http://example-domain.com/uploader/managers/file-upload` (Name: **uploader_file_upload_manager**)
    - `http://example-domain.com/uploader/managers/file-edit/{id}` (Name: **uploader_file_edit_manager**)

    For POST request method

    - `http://example-domain.com/uploader/managers/file-list/delete` (Name: **uploader_file_list_delete**)
        - Required request field is **items** - it is an array of file's ID's.

- **Album editor section**
    
    - Image albums
    
        For GET request method
    
        - `http://example-domain.com/uploader/albums/image/list` (Name: **uploader_image_album_list**)
        - `http://example-domain.com/uploader/albums/image/create` (Name: **uploader_image_album_create**)
        - `http://example-domain.com/uploader/albums/image/edit/{id}` (Name: **uploader_image_album_edit**)
        - `http://example-domain.com/uploader/albums/image/view/{id}` (Name: **uploader_image_album_view**)
        
        For POST request method
        
        - `http://example-domain.com/uploader/albums/image/store` (Name: **uploader_image_album_store**)
        - `http://example-domain.com/uploader/albums/image/update/{id}` (Name: **uploader_image_album_update**)
        - `http://example-domain.com/uploader/albums/image/delete` (Name: **uploader_image_album_delete**)

    - Audio albums
        
        For GET request method
    
        - `http://example-domain.com/uploader/albums/audio/list` (Name: **uploader_audio_album_list**)
        - `http://example-domain.com/uploader/albums/audio/create` (Name: **uploader_audio_album_create**)
        - `http://example-domain.com/uploader/albums/audio/edit/{id}` (Name: **uploader_audio_album_edit**)
        - `http://example-domain.com/uploader/albums/audio/view/{id}` (Name: **uploader_audio_album_view**)
        
        For POST request method
        
        - `http://example-domain.com/uploader/albums/audio/store` (Name: **uploader_audio_album_store**)
        - `http://example-domain.com/uploader/albums/audio/update/{id}` (Name: **uploader_audio_album_update**)
        - `http://example-domain.com/uploader/albums/audio/delete` (Name: **uploader_audio_album_delete**)
        
    - Video albums
           
        For GET request method
        
        - `http://example-domain.com/uploader/albums/video/list` (Name: **uploader_video_album_list**)
        - `http://example-domain.com/uploader/albums/video/create` (Name: **uploader_video_album_create**)
        - `http://example-domain.com/uploader/albums/video/edit/{id}` (Name: **uploader_video_album_edit**)
        - `http://example-domain.com/uploader/albums/video/view/{id}` (Name: **uploader_video_album_view**)
        
        For POST request method
        
        - `http://example-domain.com/uploader/albums/video/store` (Name: **uploader_video_album_store**)
        - `http://example-domain.com/uploader/albums/video/update/{id}` (Name: **uploader_video_album_update**)
        - `http://example-domain.com/uploader/albums/video/delete` (Name: **uploader_video_album_delete**)
        
    - Application albums
               
        For GET request method
        
        - `http://example-domain.com/uploader/albums/application/list` (Name: **uploader_application_album_list**)
        - `http://example-domain.com/uploader/albums/application/create` (Name: **uploader_application_album_create**)
        - `http://example-domain.com/uploader/albums/application/edit/{id}` (Name: **uploader_application_album_edit**)
        - `http://example-domain.com/uploader/albums/application/view/{id}` (Name: **uploader_application_album_view**)
        
        For POST request method
        
        - `http://example-domain.com/uploader/albums/application/store` (Name: **uploader_application_album_store**)
        - `http://example-domain.com/uploader/albums/application/update/{id}` (Name: **uploader_application_album_update**)
        - `http://example-domain.com/uploader/albums/application/delete` (Name: **uploader_application_album_delete**)
        
    - Word albums
                   
        For GET request method
        
        - `http://example-domain.com/uploader/albums/word/list` (Name: **uploader_word_album_list**)
        - `http://example-domain.com/uploader/albums/word/create` (Name: **uploader_word_album_create**)
        - `http://example-domain.com/uploader/albums/word/edit/{id}` (Name: **uploader_word_album_edit**)
        - `http://example-domain.com/uploader/albums/word/view/{id}` (Name: **uploader_word_album_view**)
        
        For POST request method
        
        - `http://example-domain.com/uploader/albums/word/store` (Name: **uploader_word_album_store**)
        - `http://example-domain.com/uploader/albums/word/update/{id}` (Name: **uploader_word_album_update**)
        - `http://example-domain.com/uploader/albums/word/delete` (Name: **uploader_word_album_delete**)

            
            .........................................................
            
            ................Next albums...............
            
            .........................................................

            
**E.t.c...** See in `routes/uploader.php` package file the next albums routes for **Excel**, **Visio**, **PowerPoint**, **PDF**, **Text**, **Other** albums. They have similar principle.

**Album editor** POST request method fields are equal for all albums:

- Required request fields for store: **title**, **description**.
- Required request fields for update: **title**, **description**. Field **id** is in route url.
- Required request field for delete: **items** - it is an array of album's ID's.


### 5.2 Easy quick way

#### 5.2.1 Access to File list manager

- Go directly to **uploader_file_list_manager** route: `http://example-domain.com/uploader/managers/file-list`

- Go to File list using **iframe**:

```blade
<section class="content container-fluid">
    <div class="row">
        <div class="col-12 mt-1">
            <iframe src="{{ route('uploader_file_list_manager') }}" frameborder="0" style="width: 100%; min-height: 800px"></iframe>
        </div>
    </div>
</section>
```

![MFU file list manager](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_file_list_manager.png)

#### 5.2.2 Access to File upload manager

If to click on green **Uploader** button in a file list manager, you will go to **uploader_file_upload_manager** route: `http://example-domain.com/uploader/managers/file-upload`.

![MFU file upload manager](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_file_upload_manager.png)

#### 5.2.3 Access to File edit manager

If to click on green edition button in a file list manager, you will go to **uploader_file_edit_manager** route: `http://example-domain.com/uploader/managers/file-edit/{id}`:

```php
route('uploader_file_edit_manager', ['id' => 1])
```

![MFU file edit manager](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_file_edit_manager.png)

#### 5.2.4 Access to Media file preview

If you have got a media file entry `$mediaFile` by `Itstructure\MFU\Models\Mediafile` model entity:

```php
<a href="{{ $mediaFile->getOriginalUrl() }}" target="_blank">
    {!! \Itstructure\MFU\Facades\Previewer::getPreviewHtml($mediaFile, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO) !!}
</a>
```

Here you can use some of the next options:

`\Itstructure\MFU\Services\Previewer::LOCATION_FILE_ITEM`
`\Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO`
`\Itstructure\MFU\Services\Previewer::LOCATION_EXISTING`

#### 5.2.5 Download Media file

Use route:

```php
route('uploader_file_download', ['id' => 1])
```

#### 5.2.6 Access to Album Editor

Simply use albums routes, described above in **Album editor section** of **5.1 Routes part**.

But pay attention! You must set a layout for album editor:

```php
'albums' => [
    'layout' => 'adminlte::page',
],
```

Value `adminlte::page` is for case if you use [AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE). Or you can set your special layout.

Image album list example looks like this:

![MFU album list](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_album_list.png)

Image album edition page example looks like this:

![MFU album edit](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_album_edit.png)

### 5.3 Digging deeper

#### 5.3.1 Data base structure

![MFU db](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_db.png)

#### 5.3.2 Short architecture structure and request way for uploading process in simple words

1. Call `UploadController` method.
2. Call static method from `Itstructure\MFU\Facades\Uploader` facade in controller method.
3. Get instance of Uploader service `Itstructure\MFU\Services\Uploader::getInstance($config)` and call here a facade's method.
4. Get instance of needed processor, with set config data from service to this:

    `Itstructure\MFU\Processors\UploadProcessor` or 
    
    `Itstructure\MFU\Processors\UpdateProcessor` or 
    
    `Itstructure\MFU\Processors\DeleteProcessor`.

5. Set process parameters and then call it's `run()` method.

See inside core.

#### 5.3.3 Use FileSetter

FileSetter is needed to set **file id** in to the form field and file **preview** to special container before sending request to controller during saving some entity: Page, Catalog, Product e.t.c.

Example FileSetter using for **thumbnail**:

```blade
@php
    $thumbModel = isset($model) ? $model->getThumbnailModel() : null;
@endphp
<div id="{{ isset($model) ? 'thumbnail_container_' . $model->id : 'thumbnail_container' }}">
    @if(!empty($thumbModel))
        <a href="{{ $thumbModel->getOriginalUrl() }}" target="_blank">
            {!! \Itstructure\MFU\Facades\Previewer::getPreviewHtml($thumbModel, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO) !!}
        </a>
    @endif
</div>
<div id="{{ isset($model) ? 'thumbnail_title_' . $model->id : 'thumbnail_title' }}">
    @if(!empty($thumbModel))
        {{ $thumbModel->title }}
    @endif
</div>
<div id="{{ isset($model) ? 'thumbnail_description_' . $model->id : 'thumbnail_description' }}">
    @if(!empty($thumbModel))
        {{ $thumbModel->description }}
    @endif
</div>
@php
    $fileSetterConfig = [
        'attribute' => Itstructure\MFU\Processors\SaveProcessor::FILE_TYPE_THUMB,
        'value' => !empty($thumbModel) ? $thumbModel->id : null,
        'openButtonName' => trans('uploader::main.set_thumbnail'),
        'clearButtonName' => trans('uploader::main.clear'),
        'mediafileContainerId' => isset($model) ? 'thumbnail_container_' . $model->id : 'thumbnail_container',
        'titleContainerId' => isset($model) ? 'thumbnail_title_' . $model->id : 'thumbnail_title',
        'descriptionContainerId' => isset($model) ? 'thumbnail_description_' . $model->id : 'thumbnail_description',
        //'callbackBeforeInsert' => 'function (e, v) {console.log(e, v);}',//Custom
        'neededFileType' => Itstructure\MFU\Processors\SaveProcessor::FILE_TYPE_THUMB,
        'subDir' => isset($model) ? $model->getTable() : null
    ];

    $ownerConfig = isset($ownerParams) && is_array($ownerParams) ? array_merge([
        'ownerAttribute' => Itstructure\MFU\Processors\SaveProcessor::FILE_TYPE_THUMB
    ], $ownerParams) : [];

    $fileSetterConfig = array_merge($fileSetterConfig, $ownerConfig);
@endphp
@fileSetter($fileSetterConfig)
```

Visually it looks like that:

![MFU file setter](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_file_setter.png)

If to click on **Set thumbnail** button, then file list manager will be opened, but with additional button "V":

![MFU file list with file setter button](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_file_list_with_setter_button.png)

This button is to choose a concrete file and insert it's preview in to the `thumbnail_container` and it's ID in to the automatically rendered form field by `attribute` option.

See next point **5.3.4** to understand how this selected file can be linked with a parent owner, like for example: Page, Product e.t.c...

#### 5.3.4 Link media files with parent owner

For example you use `Product` eloquent model, which contains **albums** and **media files** both.

Albums and media files can be linked with Product, after Product is saved, through `owners_albums` and `owners_mediafiles` DB relations.

This relations are set by `BehaviorMediafile` and `BehaviorAlbum` classes automatically.

```php

namespace App\Models;
    
use Illuminate\Database\Eloquent\Model;
use Itstructure\MFU\Interfaces\BeingOwnerInterface;
use Itstructure\MFU\Behaviors\Owner\{BehaviorMediafile, BehaviorAlbum};
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Models\Albums\AlbumTyped;
use Itstructure\MFU\Traits\{OwnerBehavior, Thumbnailable};
    
class Product extends Model implements BeingOwnerInterface
{
    use Thumbnailable, OwnerBehavior;
    
    protected $table = 'products';
    
    protected $fillable = ['title', 'alias', 'description', 'price', 'category_id'];
    
    public function getItsName(): string
    {
        return $this->getTable();
    }
    
    public function getPrimaryKey()
    {
        return $this->getKey();
    }
    
    public static function getBehaviorMadiafileAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_THUMB, SaveProcessor::FILE_TYPE_IMAGE];
    }
    
    public static function getBehaviorAlbumAttributes(): array
    {
        return [AlbumTyped::ALBUM_TYPE_IMAGE];
    }
    
    public static function getBehaviorAttributes(): array
    {
        return array_merge(static::getBehaviorMadiafileAttributes(), static::getBehaviorAlbumAttributes());
    }
    
    protected static function booted(): void
    {
        $behaviorMediafile = BehaviorMediafile::getInstance(static::getBehaviorMadiafileAttributes());
        $behaviorAlbum = BehaviorAlbum::getInstance(static::getBehaviorAlbumAttributes());
    
        static::saved(function (Model $ownerModel) use ($behaviorMediafile, $behaviorAlbum) {
            if ($ownerModel->wasRecentlyCreated) {
                $behaviorMediafile->link($ownerModel);
                $behaviorAlbum->link($ownerModel);
            } else {
                $behaviorMediafile->refresh($ownerModel);
                $behaviorAlbum->refresh($ownerModel);
            }
        });
    
        static::deleted(function (Model $ownerModel) use ($behaviorMediafile, $behaviorAlbum) {
            $behaviorMediafile->clear($ownerModel);
            $behaviorAlbum->clear($ownerModel);
        });
    }
}
```

The main rules:

- It is very important to be implemented from `BeingOwnerInterface`!

- It is very important to use `OwnerBehavior` trait. Some required BASE methods by `BeingOwnerInterface` are already existing in this trait.

- It is very important to make the next methods: `getItsName()`, `getPrimaryKey()`.

- It is very important to add method `booted()` with behaviour instances.

- It is very important to set `getBehaviorAttributes()` with attributes list, which are used in a blade form for **FileSetter**!

See deeper in to core and imagine how it works :-)

Go next...

It is very important to use MFU blade partials correctly in your application blade forms!

Short cut example for the blade form with using

`uploader::partials.thumbnail`,

`uploader::partials.new-mediafiles`,

`uploader::partials.existing-mediafiles`, 

`uploader::partials.albums-form-list`:

```blade
<form action="{{ route('admin_product_store') }}" method="post">

<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
        @include('uploader::partials.thumbnail', ['model' => $model ?? null, 'ownerParams' => $ownerParams ?? null])
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
        <div class="form-group">
            <label for="id_title">Title</label>
            <input id="id_title" type="text" class="form-control @if ($errors->has('title')) is-invalid @endif"
                   name="title" value="{{ old('title', !empty($model) ? $model->title : null) }}" required autofocus>
            @if ($errors->has('title'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('title') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

..........

..........

<hr />
<h5>{{ trans('uploader::main.new_files') }}</h5>
<div class="row mb-3">
    @include('uploader::partials.new-mediafiles', [
        'fileType' => \Itstructure\MFU\Processors\SaveProcessor::FILE_TYPE_IMAGE,
        'ownerParams' => $ownerParams ?? null
    ])
</div>

@if(!empty($edition))
    <hr />
    <h5>{{ trans('uploader::main.existing_files') }}</h5>
    <div class="row mb-3">
        @include('uploader::partials.existing-mediafiles', [
            'edition' => true,
            'fileType' => \Itstructure\MFU\Processors\SaveProcessor::FILE_TYPE_IMAGE,
            'ownerParams' => $ownerParams ?? null,
            'mediaFiles' => $mediaFiles ?? []
        ])
    </div>
@endif

@if(!empty($allImageAlbums) && !$allImageAlbums->isEmpty())
    <hr />
    <h5>{{ trans('uploader::main.image_albums') }}</h5>
    <div class="row mb-3">
        @include('uploader::partials.albums-form-list', [
            'albums' => $allImageAlbums,
            'edition' => true
        ])
    </div>
@endif

<button class="btn btn-primary" type="submit">Create</button>
<input type="hidden" value="{!! csrf_token() !!}" name="_token">

</form>
```

To clarify:

By `fileType` there will be set a field `image[]`, which will be set by `fill()` method in `Itstructure\MFU\Traits\OwnerBehavior` trait using `getBehaviorAttributes()`, 
and then it's value will be put in to the `BehaviorMediafile` object during `booted()` calling after for example `Product` is saved. Then a table `owners_mediafiles` will be filled. 
Link between `Product` and `Mediafile` will be created.

Product edition page example looks like this:

![MFU product edit](https://github.com/itstructure/laravel-media-file-uploader/blob/main/mfu_product_edit.png)

To see more, how that example works in global, see real example here: [Laravel Microshop Simple](https://github.com/itstructure/laravel-microshop-simple).

I hope you will be happy with this package. Good luck with your development!

With all respect, Andrey!

## License

Copyright © 2024 Andrey Girnik girnikandrey@gmail.com.

Licensed under the [MIT license](http://opensource.org/licenses/MIT). See LICENSE.txt for details.
