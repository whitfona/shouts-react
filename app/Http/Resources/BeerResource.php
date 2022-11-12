<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BeerResource extends JsonResource
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
            'id' =>$this->id,
            'barcode' => $this->barcode,
            'name' => $this->name,
            'brewery' => $this->brewery,
            'alcohol_percent' => $this->alcohol_percent,
            'photo' => $this->photo,
            'category' => $this->category->type,
            'avg_rating' => round($this->rating->avg('rating'), 1),
            'has_lactose' => $this->has_lactose,
            'rating' => RatingResource::collection($this->rating),
        ];
    }
}
