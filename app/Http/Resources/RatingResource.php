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
            'user_photo' => isset($this->user->profile_image) ? asset('/storage/users/' . $this->user->profile_image) : null,
            'date_added' => $this->updated_at->toDateString()
        ];
    }
}
