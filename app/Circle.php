<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Circle extends Model
{
    protected $fillable = ['name', 'owner_id'];

    public function stories()
    {
        return $this->hasManyThrough(Story::class, Author::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('owner', function (Builder $builder) {
            $builder->where('owner_id', Auth::id());
        });
    }
}
