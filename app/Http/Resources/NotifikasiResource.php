<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotifikasiResource extends JsonResource
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
            'id'            => $this->id,
            'judul'         => $this->judul,
            'pesan'         => $this->pesan,
            'tipe'          => $this->tipe,
            'created_at'    => $this->created_at
        ];
    }
}
