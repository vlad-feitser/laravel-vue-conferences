<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConferenceResource extends JsonResource
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
            'title' => $this->title,
            'category_id' => $this->category_id,
            'date' => $this->date,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'country' => $this->country,
            'created_at' => $this->created_at,
            'udpated_at' => $this->udpated_at,
        ];
    }
}
