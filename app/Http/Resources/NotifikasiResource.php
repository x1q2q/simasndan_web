<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Notifikasi;

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
            'tanggal'    => $this->tanggal,
            'notif_list' => Notifikasi::join('grup_notifikasi', 'notifikasi.id', '=', 'grup_notifikasi.notif_id')
            ->where('grup_notifikasi.santri_id','=',$this->santri_id)
            ->whereDate('created_at','=',$this->tanggal)
            ->orderBy('created_at','desc')->get()
        ];
    }
}
