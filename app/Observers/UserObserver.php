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
        ]);

        $scene = [];
        $i = 0;

        $scene[] = Scene::create([
            'story_id' => $story->id,
            'weight' => $i++,
            'title' => '1. Eingang',
            'body' => 'Du stehst am Eingang eines Irrgartens.',
        ]);

        $scene[] = Scene::create([
            'story_id' => $story->id,
            'weight' => $i++,
            'title' => '2. Ein enger Gang',
            'body' => 'Du befindest dich in einem Gang.',
        ]);

        $scene[] = Scene::create([
            'story_id' => $story->id,
            'weight' => $i++,
            'title' => '3. Ein Kammer',
            'body' => 'Du betrittst eine Kammer. Die Kammer hat links und gegenüber zwei Türen.',
        ]);

        $scene[] = Scene::create([
            'story_id' => $story->id,
            'weight' => $i++,
            'title' => '4. Im Garten',
            'body' => 'Du stehst in einem Garten. Ein kleines Tor führt auf die Strasse. Du hast es geschafft!',
        ]);

        Passage::create([
            'weight' => 0,
            'scene_id' => $scene[0]->id,
            'target_id' => $scene[1]->id,
            'title' => 'Betrete den Irrgarten',
        ]);

        Passage::create([
            'weight' => 0,
            'scene_id' => $scene[1]->id,
            'target_id' => $scene[2]->id,
            'title' => 'Folge dem Gang',
        ]);

        Passage::create([
            'weight' => 0,
            'scene_id' => $scene[2]->id,
            'target_id' => $scene[1]->id,
            'title' => 'Gehe durch die linke Tür',
        ]);

        Passage::create([
            'weight' => 1,
            'scene_id' => $scene[2]->id,
            'target_id' => $scene[3]->id,
            'title' => 'Gehe durch die gegenüberliegende Tür',
        ]);
    }
}