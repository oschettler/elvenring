<?php

return [
    'preheader'       => 'Ich wollte dir nur mitteilen, dass jemand auf deinen Beitrag geantwortet hat.',
    'greeting'        => 'Hi,',
    'body'            => 'Ich wollte dir nur mitteilen, das jemand auf deinen Beitrag unter',
    'view_discussion' => 'Schau dir die '.mb_strtolower(trans('chatter::intro.titles.discussion')).' rein.',
    'farewell'        => 'Noch einen schönen Tag!',
    'unsuscribe'      => [
        'message' => 'Wenn du keine Benachrichtigungen über Antworten mehr erhalten möchtest, ändere deine EInstellung am Fuß der Seite :)',
        'action'  => 'Magst du diese E-Mails nicht?',
        'link'    => 'Deaktiviere Benachrichtigungen zu dieser '.mb_strtolower(trans('chatter::intro.titles.discussion')).'.',
    ],
];
