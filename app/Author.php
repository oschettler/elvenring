<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'circle_id'];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }
}
