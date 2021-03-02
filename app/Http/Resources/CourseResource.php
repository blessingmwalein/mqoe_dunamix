<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "name" => $this->name,
            "description"=> $this->desc,
            "price"=> $this->price,
            "preview_url"=> $this->preview_url,
            "created_at" => $this->created_at,
            "url" => $this->url
        ];
    }
}
