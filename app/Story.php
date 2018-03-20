<?php

namespace App;

use App\Http\Resources\SceneResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Knowfox\Story\Services\Story as StoryService;

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

    public function getTextualScenesAttribute()
    {
        $service = app(StoryService::class);
        return $service->dump(SceneResource::collection($this->scenes)->resolve());
    }

    public function setTextualScenesAttribute($value)
    {
        $service = app(StoryService::class);
        $this->attributes['scene_data'] = $service->parse($value);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('author_circle_owner', function (Builder $builder) {
            $builder->whereHas('author');
        });
    }
}
