<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Author extends Model
{
    protected $fillable = ['name', 'circle_id'];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('circle_owner', function (Builder $builder) {
            $builder->whereHas('circle');
        });
    }
}
