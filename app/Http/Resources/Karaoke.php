<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Karaoke extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
          'id' => $this->id ,
          'user_id' => $this->title ,
          'artist' => $this->artist ,
          'title' => $this->title ,
          'memo' => $this->memo ,
        ];
    }
}
