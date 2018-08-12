<?php

return [
    'words' => [
        'cancel'  => 'Cancel',
        'delete'  => 'Delete',
        'edit'    => 'Edit',
        'yes'     => 'Yes',
        'no'      => 'No',
        'minutes' => '1 minute| :count minutes',
    ],

    'discussion' => [
        'new'          => 'Neue '.trans('chatter::intro.titles.discussion'),
        'all'          => 'Alle '.trans('chatter::intro.titles.discussions'),
        'create'       => 'Schreibe '.trans('chatter::intro.titles.discussion'),
        'posted_by'    => 'Geschrieben von',
        'head_details' => 'Geschrieben in',

    ],
    'response' => [
        'confirm'     => 'Willst du diese Antwort wirklich löschen?',
        'yes_confirm' => 'Ja, lösche sie',
        'no_confirm'  => 'Nein danke',
        'submit'      => 'Schreibe Antwort',
        'update'      => 'Korrigiere Antwort',
    ],

    'editor' => [
        'title'               => 'Titel der '.trans('chatter::intro.titles.discussion'),
        'select'              => 'Wähle eine Rubrik',
        'tinymce_placeholder' => 'Schreibe deine '.trans('chatter::intro.titles.discussion').' Hier...',
        'select_color_text'   => 'Wähle eine Farbe für diese '.trans('chatter::intro.titles.discussion').' (freiwillig)',
    ],

    'email' => [
        'notify' => 'Erhalte Benachrichtigung bei einer Antwort',
    ],

    'auth' => 'Bitte zum Mitreden <a href="/:home/login">anmelden</a>
                oder <a href="/:home/register">registrieren </a>.',

];
