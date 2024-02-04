@extends('uploader::layouts.main')
@section('title', 'File Manager')
@section('content')
    <div id="filemanager" role="filemanager" class="file-manager" data-url-info="">

        <div class="file-items">
            @php
                $gridData = [
                    'dataProvider' => $dataProvider,
                    'paginatorOptions' => [
                        'pageName' => 'p',
                        'onEachSide' => 1
                    ],
                    'rowsPerPage' => 5,
                    'title' => '',
                    'columnFields' => [
                        [
                            'attribute' => 'id',
                            'filter' => false,
                        ],
                        [
                            'label' => 'Preview',
                            'value' => function ($mediafile) {
                                return Itstructure\MFU\Facades\Previewer::getPreviewHtml($mediafile, 'fileitem');
                            },
                            'filter' => false,
                            'format' => [
                                'class' => Itstructure\GridView\Formatters\HtmlFormatter::class,
                            ]
                        ],
                        [
                            'label' => 'Title',
                            'attribute' => 'title'
                        ],
                        [
                            'label' => 'Created',
                            'attribute' => 'created_at'
                        ],
                        [
                            'label' => 'Updated',
                            'attribute' => 'updated_at'
                        ],
                    ],
                ];
            @endphp

            @gridView($gridData)
        </div>
        <div class="file-redactor">
            <div id="fileinfo" role="fileinfo">

            </div>
        </div>
    </div>
@endsection
