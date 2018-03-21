<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Knowfox\Story\Services\Story as StoryService;
use Mpociot\Versionable\VersionableTrait;

class Story extends Model
{
    use VersionableTrait;

    protected $fillable = ['public', 'status', 'title', 'summary', 'author_id', 'textual_scenes'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function legacyScenes()
    {
        return $this->hasMany(Scene::class);
    }

    public function scenes()
    {
        $service = app(StoryService::class);
        return $service->parse($this->textual_scenes);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('author_circle_owner', function (Builder $builder) {
            $builder->whereHas('author');
        });
    }
}
