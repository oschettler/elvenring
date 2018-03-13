<?php

namespace App;

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
}
