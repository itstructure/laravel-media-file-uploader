<div id="{{ isset($model) ? 'thumbnail_container_' . $model->id : 'thumbnail_container' }}">
    @if(isset($model) && !empty($thumbModel = $model->getThumbnailModel()))
        {!! \Itstructure\MFU\Facades\Previewer::getPreviewHtml($thumbModel, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO) !!}
    @endif
</div>
<div id="{{ isset($model) ? 'thumbnail_title_' . $model->id : 'thumbnail_title' }}">
    @if(isset($model) && !empty($thumbModel = $model->getThumbnailModel()))
        {{ $thumbModel->title }}
    @endif
</div>
<div id="{{ isset($model) ? 'thumbnail_description_' . $model->id : 'thumbnail_description' }}">
    @if(isset($model) && !empty($thumbModel = $model->getThumbnailModel()))
        {{ $thumbModel->description }}
    @endif
</div>
@php
    $fileSetterConfig = [
        'model' => $model ?? null,
        'attribute' => Itstructure\MFU\Processors\SaveProcessor::FILE_TYPE_THUMB,
        'openButtonName' => 'Set thumbnail',
        'clearButtonName' => 'Clear',
        'mediafileContainerId' => isset($model) ? 'thumbnail_container_' . $model->id : 'thumbnail_container',
        'titleContainerId' => isset($model) ? 'thumbnail_title_' . $model->id : 'thumbnail_title',
        'descriptionContainerId' => isset($model) ? 'thumbnail_description_' . $model->id : 'thumbnail_description',
        //'callbackBeforeInsert' => 'function (e, v) {console.log(e, v);}',//Custom
        'insertedDataType' => Itstructure\MFU\Views\FileSetter::INSERTED_DATA_ID,
        'neededFileType' => Itstructure\MFU\Processors\SaveProcessor::FILE_TYPE_THUMB,
        'subDir' => isset($model) ? $model->getTable() : null
    ];

    $ownerConfig = isset($ownerParams) && is_array($ownerParams) ? array_merge([
        'ownerAttribute' => Itstructure\MFU\Processors\SaveProcessor::FILE_TYPE_THUMB
    ], $ownerParams) : [];

    $fileSetterConfig = array_merge($fileSetterConfig, $ownerConfig);
@endphp
@fileSetter($fileSetterConfig)
