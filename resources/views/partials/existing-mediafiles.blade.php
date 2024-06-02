@foreach($mediaFiles ?? [] as $key => $mediaFile)
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4 p-2">
        <div class="p-2 file-area">
            <div class="mediafile-container" id="mediafile_container_existing_{{ $key }}">
                {!! \Itstructure\MFU\Facades\Previewer::getPreviewHtml($mediaFile, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO) !!}
            </div>
            <div class="mediafile-meta-data">
                <h5 id="title_container_existing_{{ $key }}" class="mt-0">{{ $mediaFile->title }}</h5>
                <p id="description_container_existing_{{ $key }}">{{ $mediaFile->description }}</p>
            </div>
            @php
                $fileSetterConfig = [
                    'attribute' => $fileType . '[]',
                    'value' => $mediaFile->{Itstructure\MFU\Views\FileSetter::INSERTED_DATA_ID},
                    'openButtonName' => 'Set file',
                    'clearButtonName' => 'Clear',
                    'mediafileContainerId' => 'mediafile_container_existing_' . $key,
                    'titleContainerId' => 'title_container_existing_' . $key,
                    'descriptionContainerId' => 'description_container_existing_' . $key,
                    //'callbackBeforeInsert' => 'function (e, v) {console.log(e, v);}',//Custom
                    'insertedDataType' => Itstructure\MFU\Views\FileSetter::INSERTED_DATA_ID,
                    'neededFileType' => $fileType,
                    'subDir' => null
                ];

                $ownerConfig = isset($ownerParams) && is_array($ownerParams) ? array_merge([
                    'ownerAttribute' => $fileType
                ], $ownerParams) : [];

                $fileSetterConfig = array_merge($fileSetterConfig, $ownerConfig);
            @endphp
            @fileSetter($fileSetterConfig)
        </div>
    </div>
@endforeach
