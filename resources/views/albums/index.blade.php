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
            'sendButtonLabel' => trans('uploader::main.delete'),
            'title' => $title,
            'strictFilters' => false,
            'columnFields' => [
                [
                    'label' => trans('uploader::main.thumbnail'),
                    'value' => function ($data) {
                        $thumbModel = $data->getThumbnailModel();
                        if (!empty($thumbModel)) {
                            $html = \Itstructure\MFU\Facades\Previewer::getPreviewHtml($thumbModel, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_ITEM);
                            return '<a href="' . route('uploader_' . $data->type . '_view', ['id' => $data->id]) . '">' . $html . '</a>';
                        }
                        return '';
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
