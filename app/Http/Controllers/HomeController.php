<?php

namespace App\Http\Controllers;
use App\Models\Semester;
use App\Models\Materi;
use App\Models\Santri;
use App\Models\Berita;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Notifikasi;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function dashboard(){        
        $allUsers = [
            'name_users'    => ["pengurus","santri biasa","admin", "guru", "pengasuh"],
            'jumlah_users'  => [
                $this->totalPengguna('pengurus'),
                $this->totalPengguna('santri_biasa'),
                $this->totalPengguna('admin'),
                $this->totalPengguna('guru'),
                $this->totalPengguna('pengasuh')]
        ];
        $allNotifs = $this->getAllNotifs();
        $allJadwals = $this->getAllJadwals();
        $allKelas =$this->getAllKelas();

        $jadwalYears = $this->getAbsensiJadwalYears('2023');
       
        $data = $this->getDataBasics();
        $data['stats'] = array(
            'jadwal_today'    => $this->getJadwalToday(),
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
        );
        return view('panels/dashboard', $data);
    }
    public function restricted($role){
        $data = array(
            'from'      => $role
        );
        return view('panels/restrict',$data);
    }
    public function getJadwalToday(){
        $numRows = 0;
        $date = Carbon::now()->format('Y-m-d');
        $numRows = Jadwal::whereDate('waktu_mulai','=',$date)->count();
        return $numRows;
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
    public function totalPengguna($params){
        $numRows =0;
        if($params == 'pengurus'){
            $numRows = Santri::where('is_pengurus','=',1)->count();
        }else if($params == 'santri_biasa'){
            $numRows = Santri::where('is_pengurus','=',0)->count();
        }else if($params == 'admin'){
            $numRows = Admin::where('is_pengasuh','=',0)->count();
        }else if($params == 'pengasuh'){
            $numRows = Admin::where('is_pengasuh','=',1)->count();
        }
        return $numRows;
    }
   
    public function getAllKelas(){
        $datas = [
            'name_kelas' => '',
            'jumlah_kelas' => ''
        ];
        $kelas = Kelas::groupBy('kode_kelas')->selectRaw('nama_kelas, count(id) as jumlah')->get()->toArray();
        $datas['name_kelas'] = array_map (function($value){
            return $value["nama_kelas"];
        }, $kelas);
        $datas['jumlah_kelas'] = array_map (function($value){
            return $value["jumlah"];
        }, $kelas);
        return $datas;
    }
    public function getAbsensiJadwalYears($selectedYears){
       $datas= [
            "key" => [],
            "pagi" => array(),
            "siang" => array(),
            "malam" => array()
       ];
        $matchColumn = [
            'jadwal.sistem_penilaian' => 'kehadiran',
            'penilaian.presensi'      => 'hadir'
        ];
        $jadwals = Jadwal::selectRaw('jadwal.id as id, count(jadwal.id) as jumlah')
        ->join('penilaian', 'penilaian.jadwal_id', '=', 'jadwal.id')
        ->where($matchColumn)->whereYear('jadwal.waktu_mulai', $selectedYears)
        ->groupBy('jadwal.id')->get();
        $datas['year']  = $selectedYears;
        
        $arrJadwals = $jadwals->toArray();
        $datas['data']  = array_map (function($value){
            return $value["jumlah"];
        }, $arrJadwals);

        $datas['total'] = array_sum($datas['data']);
        return $datas;
    }
    public function getAllJadwals(){
        $datas = [
            "key" => array(),
            "pagi" => array(),
            "siang" => array(),
            "malam" => array()
        ];
        $jadwals = Jadwal::selectRaw('id, count(id) as jumlah, DATE(waktu_mulai) as tanggal')
            ->groupBy('tanggal')->orderBy('waktu_mulai','desc')->limit(7)->get()->toArray();

        $datas['key']  = array_map (function($value){
            return $value["tanggal"];
        }, $jadwals);
        
        function getCountWaktuJadwal($tgl,$tipe){
            $rows = 0;
            $filtered = Jadwal::selectRaw("id, CASE WHEN TIME(waktu_mulai) BETWEEN '00:00:00' AND '10:59:00' THEN 'pagi' WHEN TIME(waktu_mulai) BETWEEN '11:00:00' AND '17:59:00' THEN 'siang' WHEN TIME(waktu_mulai) BETWEEN '18:00:00' AND '23:59:00' THEN 'malam' END as period");
            if($tipe == 'pagi'){
                $newF = array_filter($filtered->whereDate('waktu_mulai', $tgl)->get()->toArray(), function ($var, $k) {
                    return ($var['period'] == 'pagi');
                },ARRAY_FILTER_USE_BOTH );
                $rows = count($newF);
            }else if($tipe == 'siang'){
                $newF = array_filter($filtered->whereDate('waktu_mulai', $tgl)->get()->toArray(), function ($var, $k) {
                    return ($var['period'] == 'siang');
                },ARRAY_FILTER_USE_BOTH );
                $rows = count($newF);
            }else if($tipe == 'malam'){
                $newF = array_filter($filtered->whereDate('waktu_mulai', $tgl)->get()->toArray(), function ($var, $k) {
                    return ($var['period'] == 'malam');
                },ARRAY_FILTER_USE_BOTH );
                $rows = count($newF);
            }
            return $rows;    
        }

        foreach($jadwals as $val){
            $dataTempPagi = getCountWaktuJadwal($val["tanggal"],'pagi');
            array_push($datas['pagi'],$dataTempPagi);
            
            $dataTempSiang = getCountWaktuJadwal($val["tanggal"],'siang');
            array_push($datas['siang'],$dataTempSiang);
            
            $dataTempMalam = getCountWaktuJadwal($val["tanggal"],'malam');
            array_push($datas['malam'],$dataTempMalam);
        }
        return $datas;
    }
    public function getAllNotifs(){
        $datas = [
            'key1'  => 'pengumuman',
            'val1'  => array(),
            'key2'  => 'kelas',
            'val2'  => array(),
            'key3'  => 'jadwal',
            'val3'  => array(),
            'categories' => array()
        ];

        $notifs = Notifikasi::selectRaw('notifikasi.created_at, notifikasi.tipe, count(notifikasi.id) as jml_notif')
            ->join('grup_notifikasi','grup_notifikasi.notif_id','=','notifikasi.id')
            ->groupBy('notifikasi.id')->orderBy('created_at','desc')->get()->toArray();

            foreach($notifs as $val){
                if($val["tipe"] == "pengumuman"){
                    array_push($datas["val1"],$val["jml_notif"]);
                }else if($val["tipe"] == "kelas"){
                    array_push($datas["val2"],$val["jml_notif"]);
                }else if($val["tipe"] == "jadwal"){
                    array_push($datas["val3"],$val["jml_notif"]);
                }
                array_push($datas['categories'],substr($val["created_at"],0,10));
            }
        
        return $datas;
    }

}
