<?php

namespace App;

use App\Http\Resources\SceneResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Yaml\Yaml;

class Story extends Model
{
    protected $fillable = ['public', 'status', 'title', 'summary', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function scenes()
    {
        return $this->hasMany(Scene::class)->orderby('weight');
    }

    public function getYamlScenesAttribute()
    {
        return Yaml::dump(SceneResource::collection($this->scenes)->resolve(),
            4,
            4,
            Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('author_circle_owner', function (Builder $builder) {
            $builder->whereHas('author');
        });
    }
}
