<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    protected $fillable = ['title', 'body', 'story_id', 'weight'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function passages()
    {
        return $this->hasMany(Passage::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('story_author_circle_owner', function (Builder $builder) {
            $builder->whereHas('story');
        });
    }
}
