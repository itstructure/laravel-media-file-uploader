@for($i=0; $i < 6; $i++)
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4 p-2">
        <div class="p-2 file-area">
            <div class="mediafile-container" id="mediafile_container_new_{{ $i }}">
            </div>
            <div class="mediafile-meta-data">
                <h5 id="title_container_new_{{ $i }}" class="mt-0"></h5>
                <p id="description_container_new_{{ $i }}"></p>
            </div>
            @php
                $fileSetterConfig = [
                    'attribute' => $fileType . '[]',
                    'openButtonName' => 'Set file',
                    'clearButtonName' => 'Clear',
                    'mediafileContainerId' => 'mediafile_container_new_' . $i,
                    'titleContainerId' => 'title_container_new_' . $i,
                    'descriptionContainerId' => 'description_container_new_' . $i,
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
@endfor
