<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SantriResource extends JsonResource
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
            'username'      => $this->username,
            'nama_santri'   => $this->nama_santri,
            'email'         => $this->email,
            'nomor_hp'      => $this->nomor_hp,
            'tingkatan'     => $this->tingkatan,
            'tempat_lahir'  => $this->tempat_lahir,
            'tgl_lahir'     => $this->tgl_lahir,
            'alamat'        => $this->alamat,
            'foto'          => $this->foto,
            'is_pengurus'   => $this->is_pengurus,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status'        => $this->status_santri,
            'universitas'   => $this->universitas,
            'uuid'          => $this->uuid
        ];
    }
}
