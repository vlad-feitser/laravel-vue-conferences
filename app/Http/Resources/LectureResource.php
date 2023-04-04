<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'conference_id' => $this->conference_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'description' => $this->description,
            'presentation' => $this->presentation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
