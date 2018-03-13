<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    protected $fillable = ['name', 'owner_id'];

    public function stories()
    {
        return $this->hasManyThrough(Story::class, Author::class);
    }
}
