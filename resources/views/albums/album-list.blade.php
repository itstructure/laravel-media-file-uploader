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
            'rowsFormAction' => $rowsFormAction,
            'filtersFormAction' => $filtersFormAction,
            'sendButtonLabel' => trans('grid_view::grid.delete'),
            'title' => $title,
            'strictFilters' => false,
            'columnFields' => [
                [
                    'label' => 'Preview',
                    'value' => function ($row) {
                        return '';
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
@endsection
