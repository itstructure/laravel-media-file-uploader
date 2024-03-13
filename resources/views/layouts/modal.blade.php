<div class="modal" tabindex="-1"
     data-input-id="{{ $inputId }}"
     data-open-btn-id="{{ $openButtonId }}"
     data-mediafile-container-id="{{ isset($mediafileContainerId) ? $mediafileContainerId : '' }}"
     data-title-container-id="{{ isset($titleContainerId) ? $titleContainerId : '' }}"
     data-description-container-id="{{ isset($descriptionContainerId) ? $descriptionContainerId : '' }}"
     data-inserted-data-type="{{ isset($insertedDataType) ? $insertedDataType : '' }}"
     data-owner-name="{{ $ownerName }}"
     data-owner-id="{{ $ownerId }}"
     data-owner-attribute="{{ $ownerAttribute }}"
     data-needed-file-type="{{ $neededFileType }}"
     data-sub-dir="{{ $subDir }}"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>
    </div>
</div>
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