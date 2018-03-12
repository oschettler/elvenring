<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['public', 'status', 'title', 'summary', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
