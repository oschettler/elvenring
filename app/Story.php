<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Knowfox\Story\Services\Story as StoryService;
use Mpociot\Versionable\VersionableTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;


class Story extends Model implements HasMedia
{
    use VersionableTrait, HasMediaTrait;

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

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 80, 80);

        $this->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 750, 550);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('author_circle_owner', function (Builder $builder) {
            $builder->whereHas('author');
        });
    }
}
