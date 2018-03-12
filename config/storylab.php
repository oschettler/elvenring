<?php
return [
    'languages' => ['de', 'en', 'fr'],

    'entity' => [
        'layout' => 'layouts.lbd',
    ],
    'author' => [
        'extends' => 'entity',
        'model' => \App\Author::class,
        'entity_title' => [' Author', 'Authors'],
        'entity_name' => 'author',
        'order_by' => 'name',
        'columns' => [
            'name' => 'Name',
            'circle' => 'Circle',
        ],
        'fields' => [],
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
    'passage' => [
        'extends' => 'entity',
        'model' => \App\Passage::class,
        'entity_title' => [' Passage', 'Passages'],
        'entity_name' => 'passage',
        'order_by' => 'title',
        'columns' => [
            'weight' => 'Weight',
            'scene' => 'Scene',
            'target_id' => 'Target',
            'title' => 'Title',
        ],
        'fields' => [],
    ],
    'scene' => [
        'extends' => 'entity',
        'model' => \App\Scene::class,
        'entity_title' => [' Scene', 'Scenes'],
        'entity_name' => 'scene',
        'order_by' => 'title',
        'columns' => [
            'title' => 'Title',
        ],
        'fields' => [],
    ],
    'story' => [
        'extends' => 'entity',
        'model' => \App\Story::class,
        'entity_title' => [' Story', 'Stories'],
        'entity_name' => 'story',
        'order_by' => 'title',
        'columns' => [
            'public' => 'Public',
            'status' => 'Status',
            'title' => 'Title',
            'author' => 'Author',
        ],
        'fields' => [],
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
