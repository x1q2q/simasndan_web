<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MediaResource;

class BeritaResource extends JsonResource
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
            'judul'     => $this->judul_berita,
            'kategori'  => $this->kategori_berita,
            'isi'       => $this->isi_berita,
            'penulis'   => $this->penulis,
            'tanggal'   => $this->created_at,
            'media'     => new MediaResource($this->media)
        ];
    }
}
