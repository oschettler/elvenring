<?php

namespace App\Observers;

use App\Scene;

class SceneObserver
{
    public function deleting(Scene $scene)
    {
        $scene->passages()->delete();
    }
}