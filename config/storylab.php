<?php

use Illuminate\Support\Facades\Auth;

return [
    'languages' => ['de', 'en', 'fr'],

    'entity' => [
        'layout' => 'layouts.app',
    ],
    'author' => [
        'extends' => 'entity',
        'model' => \App\Author::class,
        'entity_title' => [' Author', 'Authors'],
        'entity_name' => 'author',
        'order_by' => 'name',
        'with' => 'circle',
        'columns' => [
            'name' => 'Name',
            'circle.name' => 'Circle',
        ],
        'fields' => [
            'name' => 'Name',
            'circle_id' => [
                'label' => 'Circle',
                'type' => 'select',
                'model' => \App\Circle::class,
                'field' => 'name',
            ]
        ],
    ],
    'circle' => [
        'extends' => 'entity',
        'model' => \App\Circle::class,
        'entity_title' => [' Circle', 'Circles'],
        'entity_name' => 'circle',
        'order_by' => 'name',
        'columns' => [
            'name' => 'Name',
        ],
        'fields' => [
            'name' => 'Name',
        ],
    ],
    'story' => [
        'extends' => 'entity',
        'model' => \App\Story::class,
        'entity_title' => [' Story', 'Stories'],
        'entity_name' => 'story',
        'order_by' => 'updated_at|desc',
        'show' => true,
        'has_file' => true,
        'multiple_files' => true,
        'columns' => [
            'title' => 'Title',
            'author.name' => 'Author',
            'public' => 'Public',
            'status' => 'Status',
        ],
        'fields' => [
            'title' => [
                'label' => 'Title',
                'cols' => 9,
            ],
            'public' => [
                'label' => 'Public',
                'type' => 'checkbox',
                'cols' => 3,
            ],
            'status' => [
                'label' => 'Status',
                'type' => 'select',
                'options' => 'story_status',
                'cols' => 3,
            ],
            'author_id' => [
                'label' => 'Author',
                'type' => 'select',
                'model' => \App\Author::class,
                'field' => 'name',
                'cols' => 9,
            ],
            'summary' => [
                'label' => 'Summary',
                'type' => 'textarea',
                'rows' => 4,
            ],
            'textual_scenes' => [
                'label' => 'Scenes',
                'type' => 'textarea',
                'rows' => 40,
            ],
        ],
    ],
    'user' => [
        'extends' => 'entity',
        'model' => \App\User::class,
        'entity_title' => [' User', 'Users'],
        'entity_name' => 'user',
        'order_by' => 'name',
        'columns' => [
            'name' => 'Name',
            'email' => 'E-Mail',
        ],
        'fields' => [],
    ],
];
