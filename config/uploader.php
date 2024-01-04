<?php

use Illuminate\Validation\Rule;
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Services\Previewer;

return [
    'processor' => [
        'baseUrl' => config('app.url'),
        'renameFiles' => true,
        'checkExtensionByFileType' => true,
        'maxFileSize' => 100 * 1024,// Kilobytes
        'fileExtensions' => [
            SaveProcessor::FILE_TYPE_THUMB => [
                'png', 'jpg', 'jpeg', 'gif',
            ],
            SaveProcessor::FILE_TYPE_IMAGE => [
                'png', 'jpg', 'jpeg', 'gif',
            ],
            SaveProcessor::FILE_TYPE_AUDIO => [
                'mp3',
            ],
            SaveProcessor::FILE_TYPE_VIDEO => [
                'mp4', 'ogg', 'ogv', 'oga', 'ogx', 'webm',
            ],
            SaveProcessor::FILE_TYPE_APP => [
                'doc', 'docx', 'rtf', 'pdf', 'rar', 'zip', 'jar', 'mcd', 'xls',
            ],
            SaveProcessor::FILE_TYPE_TEXT => [
                'txt',
            ],
            SaveProcessor::FILE_TYPE_OTHER => null,
        ],
        'thumbSizes' => [
            SaveProcessor::THUMB_ALIAS_DEFAULT => [
                'name' => 'Default size',
                'size' => [200, null],
            ],
            SaveProcessor::THUMB_ALIAS_SMALL => [
                'name' => 'Small size',
                'size' => [100, null],
            ],
            SaveProcessor::THUMB_ALIAS_MEDIUM => [
                'name' => 'Medium size',
                'size' => [400, null],
            ],
            SaveProcessor::THUMB_ALIAS_LARGE => [
                'name' => 'Large size',
                'size' => [970, null],
            ],
        ],
        'thumbFilenameTemplate' => '{original}-{width}-{height}-{alias}.{extension}',
        'baseUploadDirectories' => [
            SaveProcessor::FILE_TYPE_IMAGE => 'images',
            SaveProcessor::FILE_TYPE_AUDIO => 'audio',
            SaveProcessor::FILE_TYPE_VIDEO => 'video',
            SaveProcessor::FILE_TYPE_APP => 'application',
            SaveProcessor::FILE_TYPE_TEXT => 'text',
            SaveProcessor::FILE_TYPE_OTHER => 'other',
        ],
        'metaDataValidationRules' => [
            'alt' => 'nullable|string|max:128',
            'title' => 'nullable|string|max:128',
            'description' => 'nullable|string|max:2048',
            'owner_id' => 'nullable|numeric',
            'owner_name' => 'nullable|string|max:64',
            'owner_attribute' => 'nullable|string|max:64',
            'needed_file_type' => [
                'nullable',
                Rule::in([
                    SaveProcessor::FILE_TYPE_THUMB,
                    SaveProcessor::FILE_TYPE_IMAGE,
                    SaveProcessor::FILE_TYPE_AUDIO,
                    SaveProcessor::FILE_TYPE_VIDEO,
                    SaveProcessor::FILE_TYPE_APP,
                    SaveProcessor::FILE_TYPE_TEXT,
                    SaveProcessor::FILE_TYPE_OTHER
                ])
            ],
            'sub_dir' => 'nullable|string|max:64'
        ],
    ],
    'routing' => [
        'middlewares' => ['auth'],
    ],
    'preview' => [
        'htmlAttributes' => [
            SaveProcessor::FILE_TYPE_IMAGE => [
                Previewer::LOCATION_FILE_ITEM => [
                    'width' => 200,
                    'height' => 200
                ],
                Previewer::LOCATION_FILE_INFO => [
                    'width' => 200,
                    'height' => 200
                ],
                Previewer::LOCATION_EXISTING => [
                    'width' => 400,
                    'height' => 400
                ],
            ],
            SaveProcessor::FILE_TYPE_AUDIO => [
                Previewer::LOCATION_FILE_ITEM => [
                    'width' => 300
                ],
                Previewer::LOCATION_FILE_INFO => [
                    'width' => 300
                ],
                Previewer::LOCATION_EXISTING => [
                    'width' => 300
                ],
            ],
            SaveProcessor::FILE_TYPE_VIDEO => [
                Previewer::LOCATION_FILE_ITEM => [
                    'width' => 300,
                    'height' => 240
                ],
                Previewer::LOCATION_FILE_INFO => [
                    'width' => 300,
                    'height' => 240
                ],
                Previewer::LOCATION_EXISTING => [
                    'width' => 300,
                    'height' => 240
                ],
            ],
            SaveProcessor::FILE_TYPE_APP => [
                Previewer::LOCATION_FILE_ITEM => [
                    'width' => 50
                ],
            ],
            SaveProcessor::FILE_TYPE_TEXT => [
                Previewer::LOCATION_FILE_ITEM => [
                    'width' => 50
                ],
            ],
            SaveProcessor::FILE_TYPE_OTHER => [
                Previewer::LOCATION_FILE_ITEM => [
                    'width' => 50
                ],
            ]
        ]
    ]
];
