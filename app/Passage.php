<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('scene_story_author_circle_owner', function (Builder $builder) {
            $builder->whereHas('scene');
        });
    }
}
