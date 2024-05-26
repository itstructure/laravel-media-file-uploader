@extends($albumsLayout)
@section('title', $title)
@section('content')
    @php
        $gridData = [
            'dataProvider' => $dataProvider,
            'paginatorOptions' => [
                'pageName' => 'p',
                'onEachSide' => 1
            ],
            'rowsPerPage' => 5,
            'rowsFormAction' => route('uploader_' . $type . '_delete'),
            'filtersFormAction' => route('uploader_' . $type . '_list'),
            'sendButtonLabel' => trans('grid_view::grid.delete'),
            'title' => $title,
            'strictFilters' => false,
            'columnFields' => [
                [
                    'label' => 'Preview',
                    'value' => function ($data) {
                        $thumbModel = $data->getThumbnailModel();
                        return !empty($thumbModel)
                            ? \Itstructure\MFU\Facades\Previewer::getPreviewHtml($thumbModel, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_ITEM)
                            : '';
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
                    'class' => Itstructure\GridView\Columns\ActionColumn::class,
                    'actionTypes' => [
                        'view' => function ($data) {
                            return route('uploader_' . $data->type . '_view', ['id' => $data->id]);
                        },
                        'edit' => function ($data) {
                            return route('uploader_' . $data->type . '_edit', ['id' => $data->id]);
                        },
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
@endsection
