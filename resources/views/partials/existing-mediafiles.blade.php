@foreach($mediaFiles ?? [] as $key => $mediaFile)
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4 p-2">
        <div class="p-2 file-area">
            <div class="mediafile-container" id="mediafile_container_existing_{{ $key }}">
                <a href="{{ $mediaFile->getOriginalUrl() }}" target="_blank">
                    {!! \Itstructure\MFU\Facades\Previewer::getPreviewHtml($mediaFile, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO) !!}
                </a>
            </div>
            <div class="mediafile-meta-data">
                <h5 id="title_container_existing_{{ $key }}" class="mt-0">{{ $mediaFile->title }}</h5>
                <p id="description_container_existing_{{ $key }}">{{ $mediaFile->description }}</p>
            </div>
            @if(!empty($edition))
                @php
                    $fileSetterConfig = [
                        'attribute' => $fileType . '[]',
                        'value' => $mediaFile->id,
                        'openButtonName' => trans('uploader::main.set_file'),
                        'clearButtonName' => trans('uploader::main.clear'),
                        'mediafileContainerId' => 'mediafile_container_existing_' . $key,
                        'titleContainerId' => 'title_container_existing_' . $key,
                        'descriptionContainerId' => 'description_container_existing_' . $key,
                        //'callbackBeforeInsert' => 'function (e, v) {console.log(e, v);}',//Custom
                        'neededFileType' => $fileType,
                        'subDir' => null
                    ];

                    $ownerConfig = isset($ownerParams) && is_array($ownerParams) ? array_merge([
                        'ownerAttribute' => $fileType
                    ], $ownerParams) : [];

                    $fileSetterConfig = array_merge($fileSetterConfig, $ownerConfig);
                @endphp
                @fileSetter($fileSetterConfig)
            @endif
        </div>
    </div>
@endforeach
