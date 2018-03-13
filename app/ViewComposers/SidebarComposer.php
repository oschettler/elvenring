<?php

namespace App\ViewComposers;

use App\Author;
use App\Circle;
use App\Passage;
use App\Scene;
use App\Story;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view)
    {
        $count = [];

        foreach ([
             'circle' => Circle::class,
             'author' => Author::class,
             'story' => Story::class,
             'scene' => Scene::class,
             'passage' => Passage::class,
            ] as $name => $entity) {

            $count[$name] = $entity::count();
        }
        $view->with('count', $count);
    }
}