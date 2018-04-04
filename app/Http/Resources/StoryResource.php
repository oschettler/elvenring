<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Knowfox\Story\Services\Story as StoryService;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $service = app(StoryService::class);

        $keep_tags = $request->has('keep_tags')
            ? '<u><code>' : '';

        return [
            'id' => $this->id,
            'public' => $this->public ? true : false,
            'status' => $this->status,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'summary' => $this->summary,
            'scenes' => array_map(function ($scene) use ($keep_tags) {
                $scene->body = trim(strip_tags($scene->body, $keep_tags));
                return $scene->toArray();
            }, $service->parse($this->textual_scenes))
        ];
    }
}
