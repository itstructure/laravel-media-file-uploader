@extends('uploader::layouts.main')
@section('title', trans('uploader::main.files'))
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
                'rowsFormAction' => route('uploader_file_list_delete'),
                'filtersFormAction' => route('uploader_file_list_manager'),
                'sendButtonLabel' => trans('uploader::main.delete'),
                'title' => '',
                'strictFilters' => false,
                'columnFields' => [
                    [
                        'label' => trans('uploader::main.thumbnail'),
                        'value' => function ($row) {
                            return Itstructure\MFU\Facades\Previewer::getPreviewHtml($row, Itstructure\MFU\Services\Previewer::LOCATION_FILE_ITEM);
                        },
                        'filter' => false,
                        'format' => [
                            'class' => Itstructure\GridView\Formatters\HtmlFormatter::class,
                        ]
                    ],
                    [
                        'label' => trans('uploader::main.title'),
                        'attribute' => 'title'
                    ],
                    [
                        'label' => trans('uploader::main.created'),
                        'attribute' => 'created_at'
                    ],
                    [
                        'label' => trans('uploader::main.updated'),
                        'attribute' => 'updated_at'
                    ],
                    [
                        'label' => trans('uploader::main.actions'),
                        'value' => function ($row) use ($fromFileSetter) {
                            return view('uploader::partials.file-list-actions', ['row' => $row, 'fromFileSetter' => !empty($fromFileSetter)]);
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
