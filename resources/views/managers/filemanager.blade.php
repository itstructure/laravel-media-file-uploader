@php

@endphp

{{--<link rel="stylesheet" href="{{ asset('vendor/uploader/css/modal.css') }}">--}}

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
                        'value' => function ($row) {
                            return $row->icon;
                        },
                        'filter' => false,
                        'format' => [
                            'class' => Itstructure\GridView\Formatters\ImageFormatter::class,
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
