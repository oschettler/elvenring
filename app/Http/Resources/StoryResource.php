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

        return [
            'public' => $this->public ? true : false,
            'status' => $this->status,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'summary' => $this->summary,
            'scenes' => $service->parse($this->textual_scenes),
        ];
    }
}
