<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    protected $fillable = ['weight', 'scene_id', 'target_id', 'title'];

    public function scene()
    {
        return $this->belongsTo(Scene::class);
    }

    public function target()
    {
        return $this->belongsTo(Scene::class, 'target_id');
    }
}
