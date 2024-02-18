@extends('uploader::layouts.main')
@section('title', 'File List')
@section('content')
    <div class="file-list">
        @php
            $gridData = [
                'dataProvider' => $dataProvider,
                'paginatorOptions' => [
                    'pageName' => 'p',
                    'onEachSide' => 1
                ],
                'rowsPerPage' => 5,
                'title' => '',
                 'strictFilters' => false,
                'rowsFormAction' => route('admin_product_delete'),
                'columnFields' => [
                    [
                        'label' => 'Preview',
                        'value' => function ($mediafile) {
                            return Itstructure\MFU\Facades\Previewer::getPreviewHtml($mediafile, Itstructure\MFU\Services\Previewer::LOCATION_FILE_ITEM);
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
                    [
                        'class' => Itstructure\GridView\Columns\ActionColumn::class,
                        'actionTypes' => [
                            [
                                'class' => Itstructure\GridView\Actions\Edit::class,
                                'url' => function ($row) {
                                    return route('uploader_file_edit_manager', ['id' => $row->id]);
                                },
                                'htmlAttributes' => [
                                    'style' => 'color: white; font-size: 16px;'
                                ]
                            ],
                        ],
                        'htmlAttributes' => [
                            'width' => '120'
                        ]
                    ],
                    [
                        'class' => Itstructure\GridView\Columns\CheckboxColumn::class,
                        'field' => 'items',
                        'attribute' => 'id'
                    ],
                ],
            ];
        @endphp

        @gridView($gridData)
    </div>
@endsection
