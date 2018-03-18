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
    'passage' => [
        'extends' => 'entity',
        'model' => \App\Passage::class,
        'entity_title' => [' Passage', 'Passages'],
        'entity_name' => 'passage',
        'order_by' => 'title',
        'columns' => [
            'weight' => 'Weight',
            'scene.title' => 'Scene',
            'target.title' => 'Target',
            'title' => 'Title',
        ],
        'fields' => [
            'title' => [
                'label' => 'Title',
                'cols' => 9,
            ],
            'weight' => [
                'label' => 'Weight',
                'type' => 'select',
                'options' => 'weight',
                'cols' => 3
            ],
            'scene_id' => [
                'label' => 'Scene',
                'type' => 'select',
                'model' => \App\Scene::class,
                'field' => 'title',
            ],
            'target_id' => [
                'label' => 'Target Scene',
                'type' => 'select',
                'model' => \App\Scene::class,
                'field' => 'title',
            ],
        ],
    ],
    'scene' => [
        'extends' => 'entity',
        'model' => \App\Scene::class,
        'entity_title' => [' Scene', 'Scenes'],
        'entity_name' => 'scene',
        'order_by' => ['story_id|desc', 'weight'],
        'columns' => [
            'title' => 'Title',
            'story.title' => 'Story',
        ],
        'fields' => [
            'title' => [
                'label' => 'Title',
                'cols' => 9,
            ],
            'weight' => [
                'label' => 'Weight',
                'type' => 'select',
                'options' => 'weight',
                'cols' => 3,
            ],
            'story_id' => [
                'label' => 'Story',
                'type' => 'select',
                'model' => \App\Story::class,
                'field' => 'title',
            ],
            'body'=> [
                'label'=> 'Body',
                'type' => 'textarea',
                'rows' => 16,
            ],
        ],
    ],
    'story' => [
        'extends' => 'entity',
        'model' => \App\Story::class,
        'entity_title' => [' Story', 'Stories'],
        'entity_name' => 'story',
        'order_by' => 'title',
        'show' => true,
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
                'rows' => 10,
            ],
            'yaml_scenes' => [
                'label' => 'Scenes',
                'type' => 'textarea',
                'rows' => 40,
            ]
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
