<?php

namespace App\Observers;

use App\Author;
use App\Circle;
use App\Passage;
use App\Scene;
use App\Story;
use App\User;

class UserObserver
{
    /**
     * Create initial user setup and example story
     * @param User $user
     */
    public function created(User $user)
    {
        $circle = Circle::create([
            'name' => 'Meine Geschichten',
            'owner_id' => $user->id,
        ]);

        $author_name = preg_replace('/\s.*$/', '', $user->name);
        $author = Author::create([
            'name' => $author_name,
            'circle_id' => $circle->id,
        ]);

        $story = Story::create([
            'title' => 'Ein Irrgarten',
            'summary' => 'Beispiel für eine Geschichte aus vier Szenen.',
            'author_id' => $author->id,
            'textual_scenes' => <<<EOS
Eingang

Du stehst am Eingang eines Irrgartens.

    [- Betrete den Irrgarten -> Ein enger Gang]

---
Ein enger Gang

Du befindest dich in einem Gang.

    [- Folge dem Gang -> Eine Kammer]

---
Eine Kammer

Du betrittst eine Kammer. Die Kammer hat links und gegenüber zwei Türen.

    [- Gehe durch die linke Tür -> Ein enger Gang]
[- Gehe durch die gegenüberliegende Tür -> Im Garten]

---
Im Garten

Du stehst in einem Garten. Ein kleines Tor führt auf die Strasse. Du hast es geschafft!
EOS
        ]);
    }
}