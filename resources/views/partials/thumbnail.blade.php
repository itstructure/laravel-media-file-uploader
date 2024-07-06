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
