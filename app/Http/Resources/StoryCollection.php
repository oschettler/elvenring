<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($story) {
                return [
                    'id' => $story->id,
                    'public' => $story->public ? true : false,
                    'status' => $story->status,
                    'title' => $story->title,
                    'created_at' => $story->created_at,
                    'updated_at' => $story->updated_at,
                    'summary' => $story->summary,
                ];
            }),
        ];
    }
}
