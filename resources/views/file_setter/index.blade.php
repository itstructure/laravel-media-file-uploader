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
    'inputId' => $inputId,
    'openButtonId' => $openButtonId,
    'mediafileContainerId' => $mediafileContainerId,
    'titleContainerId' => $titleContainerId,
    'descriptionContainerId' => $descriptionContainerId,
    'ownerName' => $ownerName,
    'ownerId' => $ownerId,
    'ownerAttribute' => $ownerAttribute,
    'neededFileType' => $neededFileType,
    'subDir' => $subDir
])
<script>
    if (window.csrf_token === undefined) {
        var csrf_token = '{{ csrf_token() }}';
    }
    if (window.route_file_preview === undefined) {
        var route_file_list_manager = '{{ route('uploader_file_list_manager') }}';
    }
    if (window.route_file_preview === undefined) {
        var route_file_preview = '{{ route('uploader_file_preview') }}';
    }
</script>
@if(!empty($callbackBeforeInsert))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#{{ $inputId }}").on("beforeInsert", {!! $callbackBeforeInsert !!});
        });
    </script>
@endif