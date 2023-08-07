<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Jadwal;

class PenilaianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $matchColumn = ['penilaian.santri_id' => $this->santri_id, 'semester' => $this->semester_id,'materi_id' => $this->materi_id];
        return [
            'materi'    => $this->nama_materi,
            'penilaian' =>  Jadwal::select('jadwal.kegiatan','jadwal.kode_kelas','jadwal.waktu_mulai',
            'jadwal.sistem_penilaian','penilaian.nilai','penilaian.presensi','penilaian.id','penilaian.deskripsi',
            'materi.nama_materi','santri.nama_santri','guru.nama_guru')
            ->join('penilaian', 'jadwal.id', '=', 'penilaian.jadwal_id')
            ->join('materi', 'jadwal.materi_id', '=', 'materi.id')
            ->join('santri', 'penilaian.santri_id', '=', 'santri.id')
            ->join('semester', 'jadwal.semester_id', '=', 'semester.id')
            ->join('guru', 'penilaian.guru_id', '=', 'guru.id')
            ->where($matchColumn)->orderBy('jadwal.waktu_mulai','desc')->get()
        ];
    }
}
