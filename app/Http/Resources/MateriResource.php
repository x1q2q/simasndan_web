<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MateriResource extends JsonResource
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
            'id'        => $this->id,
            'kode'      => $this->kode_materi,
            'nama'      => $this->nama_materi,
            'foto'      => $this->foto,
            'link'      => $this->link_materi,
            'deskripsi' => $this->deskripsi
        ];
    }
}
