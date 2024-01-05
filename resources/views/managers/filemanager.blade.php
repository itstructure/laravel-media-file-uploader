@extends('uploader::layouts.main')
@section('title', 'File Manager')
@section('content')
    <div id="filemanager" role="filemanager" data-url-info="">

        <div class="items">
            @php
                $gridData = [
                    'dataProvider' => $dataProvider,
                    'paginatorOptions' => [
                        'pageName' => 'p',
                    ],
                    'rowsPerPage' => 5,
                    'title' => 'Media files',
                    'columnFields' => [
                        [
                            'attribute' => 'id',
                            'filter' => false,
                            'htmlAttributes' => [
                                'width' => '5%',
                            ],
                        ],
                        [
                            'label' => 'Icon',
                            'value' => function ($mediafile) {
                                return Itstructure\MFU\Facades\Previewer::getPreviewHtml($mediafile, 'fileitem');
                            },
                            'filter' => false,
                            'format' => [
                                'class' => Itstructure\GridView\Formatters\HtmlFormatter::class,
                                'htmlAttributes' => [
                                    'width' => '100'
                                ]
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
                    ],
                ];
            @endphp

            @gridView($gridData)
        </div>
        <div class="redactor">
            <div id="fileinfo" role="fileinfo">

            </div>
        </div>
    </div>
@endsection
