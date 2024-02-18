<div class="input-group">
    @include('uploader::file_setter.input', [
        'attribute' => $attribute,
        'value' => $value,
        'inputId' => $inputId
    ])
    <span class="input-group-btn">
        @include('uploader::file_setter.open_button', [
            'openButtonId' => $openButtonId,
            'openButtonName' => $openButtonName
        ])
        @include('uploader::file_setter.clear_button', [
            'inputId' => $inputId,
            'mediafileContainerId' => $mediafileContainerId,
            'titleContainerId' => $titleContainerId,
            'descriptionContainerId' => $descriptionContainerId,
            'clearButtonName' => $clearButtonName
        ])
    </span>
    @if(!empty($deleteBoxDisplay))
        <span class="delete-box">
            @include('uploader::file_setter.delete_box', [
                'deleteBoxAttribute' => $deleteBoxAttribute,
                'deleteBoxValue' => $deleteBoxValue,
                'deleteBoxName' => $deleteBoxName
            ])
        </span>
    @endif
</div>
@include('uploader::layouts.modal', [
    'fileManagerRoute' => $fileManagerRoute,
    'inputId' => $inputId,
    'openButtonId' => $openButtonId,
    'mediafileContainerId' => $mediafileContainerId,
    'titleContainerId' => $titleContainerId,
    'descriptionContainerId' => $descriptionContainerId,
    'insertedDataType' => $insertedDataType,
    'ownerName' => $ownerName,
    'ownerId' => $ownerId,
    'ownerAttribute' => $ownerAttribute,
    'neededFileType' => $neededFileType,
    'subDir' => $subDir
])
