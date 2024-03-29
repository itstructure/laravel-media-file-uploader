@extends('uploader::layouts.main')
@section('title', 'File List')
@section('content')
    <div id="file_list" class="file-list">
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
                        'value' => function ($row) {
                            return Itstructure\MFU\Facades\Previewer::getPreviewHtml($row, Itstructure\MFU\Services\Previewer::LOCATION_FILE_ITEM);
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
                        'label' => 'Actions',
                        'value' => function ($row) {
                            return view('uploader::partials.list-actions', ['row' => $row]);
                        },
                        'filter' => false,
                        'format' => [
                            'class' => Itstructure\GridView\Formatters\HtmlFormatter::class,
                        ],
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
