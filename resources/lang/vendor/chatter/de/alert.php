<?php

return [
    'success' => [
        'title'  => 'Gut gemacht!',
        'reason' => [
            'submitted_to_post'       => 'Antwort auf '.mb_strtolower(trans('chatter::intro.titles.discussion')).' übermittelt.',
            'updated_post'            => mb_strtolower(trans('chatter::intro.titles.discussion')).' korrigiert.',
            'destroy_post'            => 'Beitrag zu '.mb_strtolower(trans('chatter::intro.titles.discussion')).' gelöscht.',
            'destroy_from_discussion' => 'Antwort auf '.mb_strtolower(trans('chatter::intro.titles.discussion')).' gelöscht.',
            'created_discussion'      => 'Neue '.mb_strtolower(trans('chatter::intro.titles.discussion')).' angelegt.',
        ],
    ],
    'info' => [
        'title' => 'Achtung!',
    ],
    'warning' => [
        'title' => 'Oh je!',
    ],
    'danger'  => [
        'title'  => 'Mist!',
        'reason' => [
            'errors'            => 'Bitte korrigiere die folgenden Fehler:',
            'prevent_spam'      => 'Um Spam zu vermeiden, warte mindestens :minutes zwischen Beiträgen.',
            'trouble'           => 'Es gab ein Problem bei der Übermittlung.',
            'update_post'       => 'Nah ah ah... Ich konnte deine Antwort nicht korrigieren. Bitte versuche keine Tricks.',
            'destroy_post'      => 'Nah ah ah... Ich konnte deine Antwort nicht löschen. Bitte versuche keine Tricks.',
            'create_discussion' => 'Whoops :( Es gab ein Problem beim Anlegen deiner '.mb_strtolower(trans('chatter::intro.titles.discussion')).'.',
        	'title_required'    => 'Bitte verfasse einen Titel',
        	'title_min'		    => 'Der Titel muss mindestens :min Zeichen lang sein.',
        	'title_max'		    => 'Der Titel darf nicht länger als :max Zeichen sein.',
        	'content_required'  => 'Bitte schreibe etwas',
        	'content_min'  		=> 'Der Beitrag muss mindestens :min Zeichen lang sein',
        	'category_required' => 'Bitte wähle eine Rubrik',

       
       
        ],
    ],
];
