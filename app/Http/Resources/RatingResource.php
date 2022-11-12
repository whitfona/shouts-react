<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            'user_id' => $this->user->id,
            'user' => $this->user->name,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'user_photo' => $this->user->profile_image,
            'date_added' => $this->created_at->toDateString()
        ];
    }
}
