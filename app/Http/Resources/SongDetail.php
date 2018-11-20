<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SongDetail extends JsonResource
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
        return [
          'id' => $this->id ,
          'artist_id' => $this->artist_id ,
          'song_id' => $this->song_id ,
          'score' => $this->score ,
          'comment' => $this->comment ,
          'created_at' => $this->created_at->format('Y-m-d') ,
          'updated_at' => $this->updated_at->format('Y-m-d') ,
        ];
    }
}
