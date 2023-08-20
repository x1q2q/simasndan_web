<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Materi;
use App\Models\Santri;
use App\Models\Berita;

class HomeController extends Controller
{
    public function dashboard(){
        $table = request()->session()->get('table');
        $allUsers = [
            'name_users'    => ["pengurus","santri biasa","admin", "guru", "pengasuh"],
            'jumlah_users'  => [10,15,5,20,30]
        ];
        $allNotifs = [
            'key1' => 'pengumuman',
            'val1' => [15,10,5,7,8,9,12],
            'key2' => 'kelas',
            'val2' => [8,9,0,0,2,7,8],
            'key3' => 'jadwal',
            'val3' => [9,6,2,4,0,0,0]
        ];
        $allJadwals = [
            'key'   => ["Senin", "Selasa", "Rabu", "Kamis","Jumat"],
            'pagi'  => [2,5,6,7,3],
            'siang' => [4,6,9,2,1],
            'malam' => [1,3,6,8,2]
        ];
        $allKelas = [
            'name_kelas'    => ["pengurus","santri biasa","admin", "guru", "pengasuh"],
            'jumlah_kelas'  => [10,15,5,20,30]
        ];
        $jadwalYears = [
            'year'  => '2022',
            'total' => 3467,
            'data'  => [4500000,600000,7000000,5500000,5000000,8000000]
        ];
        $data = array(
            'nama'          => Auth::guard($table)->user()->username,
            'nama_lengkap'  => $this->getNamaLengkap($table),
            'role'          => request()->session()->get('role'),
            'stats'         => array(
                'total_materi'    => $this->getTotalRows('materi'),
                'total_semester'  => $this->getTotalRows('semester'),
                'total_santri'=> $this->getTotalRows('santri'),
                'total_berita'=> $this->getTotalRows('berita'),
                'santri_aktif'      => $this->getTotalRows('santri','aktif'),
                'santri_alumni'     => $this->getTotalRows('santri','alumni'),
                'berita_pengumuman' => $this->getTotalRows('berita','pengumuman'),
                'berita_artikel'    => $this->getTotalRows('berita','artikel'),
                'berita_jadwal'     => $this->getTotalRows('berita','jadwal'),
                'all_users'         => $allUsers,
                'all_notifs'        => $allNotifs,
                'all_jadwals'       => $allJadwals,
                'all_kelas'       => $allKelas,
                'jadwal_years'      => $jadwalYears
            )
        );
        return view('panels/dashboard', $data);
    }
    public function restricted($role){
        $data = array(
            'from'      => $role
        );
        return view('panels/restrict',$data);
    }
    public function getNamaLengkap($table){ // santri, admin, guru
        $namaLengkap = '';
        if($table == 'santri'){
            $namaLengkap = Auth::guard($table)->user()->nama_santri;
        }else if($table == 'guru'){
            $namaLengkap = Auth::guard($table)->user()->nama_guru;
        }else{ // admin
            $namaLengkap = Auth::guard($table)->user()->nama_admin;
        }
        return $namaLengkap;
    }
    public function getTotalRows($tipe, $additional=''){
        $numRows = 0;
        if($tipe == 'semester'){
            $numRows = Semester::count();
        }else if($tipe == 'materi'){
            $numRows  = Materi::count();
        }else if($tipe == 'santri'){
            if($additional != ''){
                $numRows = Santri::where('status_santri','=',$additional)->count();
            }else{
                $numRows = Santri::count();
            }
        }else if($tipe == 'berita'){
            if($additional != ''){
                $numRows = Berita::where('kategori_berita','=',$additional)->count();
            }else{
                $numRows = Berita::count();
            }
        }
        return $numRows;
    }

}
