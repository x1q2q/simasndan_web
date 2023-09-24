<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Penilaian;
use App\Models\Semester;
use App\Models\Santri;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    public function index(){        
        $data = $this->getDataBasics();
        return view('panels.data_jadwal', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $beritaLists = Jadwal::select('*')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('kegiatan', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('kode_kelas', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('waktu_mulai', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('created_at', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($beritaLists)->addIndexColumn()->toJson();
    }
    public function getKelasData(){
        $kelas = Kelas::groupBy('kode_kelas')->get()->toArray();
        return json_encode($kelas);
    }
    public function getMateriData(){
        $materi = Materi::all()->toArray();
        return json_encode($materi);
    }
    public function getSemesterData(){
        $semester = Semester::all()->toArray();
        return json_encode($semester);
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required',
            'kode_kelas' => 'required',
            'sistem_penilaian' => 'required',
            'materi_id' => 'required',
            'semester_id' => 'required',
            'waktu_mulai' => 'required'
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data jadwal gagal dimasukkan'
              ];
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date("Y-m-d");
            $waktuMulai = $request->waktu_mulai;
            $timeStart = $tanggal . ' ' . $waktuMulai . ':00';
            $jadwal = new Jadwal();
            $jadwal->kegiatan       = $request->kegiatan;
            $jadwal->kode_kelas     = $request->kode_kelas;
            $jadwal->waktu_mulai    = date('Y-m-d H:i:s', strtotime($timeStart));
            $jadwal->created_at     = Carbon::now();
            $jadwal->sistem_penilaian= $request->sistem_penilaian;
            $jadwal->materi_id      = $request->materi_id;
            $jadwal->semester_id    = $request->semester_id;
            if($jadwal->save()){
                $table = request()->session()->get('table');
                $kelas = Kelas::where('kode_kelas', '=', $request->kode_kelas)->get()->toArray();
                $dtIdSantri = array_map (function($value){
                    return $value['santri_id'];
                    }, $kelas);
                
                $dtIdFiltered = Santri::where('fcm_token','!=',null)->whereIn('id',$dtIdSantri)->pluck('id')->toArray();
                    
                foreach($dtIdSantri as $santriVal){
                    $penilaian = new Penilaian();
                    $penilaian->nilai = 0;
                    $penilaian->presensi = 'absen';
                    $penilaian->deskripsi = '';
                    $penilaian->kode_kelas = $request->kode_kelas;
                    $penilaian->guru_id = Auth::guard($table)->user()->id;
                    $penilaian->santri_id = $santriVal;
                    $penilaian->jadwal_id = $jadwal->id;
                    $penilaian->created_at = Carbon::now();
                    $penilaian->save();
                }
                $notifsData = [
                    'judul' => 'Jadwal Kelas '.$request->kegiatan,
                    'pesan'  => 'Ada jadwal kelas untuk kelas '.$request->kode_kelas.' dimulai pada '. $request->waktu_mulai,
                    'tipe'  => 'kelas',
                    'selected' => $dtIdFiltered,
                ];
                $sendNotif = app('App\Http\Controllers\NotifikasiController')->sendNotifications($notifsData);
            }

            $result = [
                'status' => 200,
                'data'   => $sendNotif
            ];
            if($sendNotif == 'berhasil'){
                $result['message'] = 'Data jadwal berhasil dimasukkan & notifikasi berhasil  dikirimkan';
            }else{
                $result['message'] = 'Data jadwal berhasil dimasukkan, namun token '.$sendNotif;
            }
        }

        return response()->json($result);
    }
    public function detail($id){
        $data['jadwal'] = Jadwal::select('jadwal.*','kelas.nama_kelas','semester.tahun_pelajaran','semester.semester','materi.nama_materi')
                    ->join('kelas', 'jadwal.kode_kelas', '=', 'kelas.kode_kelas')
                    ->join('materi', 'jadwal.materi_id', '=', 'materi.id')
                    ->join('semester', 'jadwal.semester_id', '=', 'semester.id')
                    ->where('jadwal.id', '=', $id)->first();
        return json_encode($data);
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required',
            'kode_kelas' => 'required',
            'sistem_penilaian' => 'required',
            'materi_id' => 'required',
            'semester_id' => 'required',
            'waktu_mulai' => 'required'
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data jadwal gagal diupdate'
              ];
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date("Y-m-d");
            $waktuMulai = $request->waktu_mulai;
            $timeStart = $tanggal . ' ' . $waktuMulai . ':00';
            $jadwal = Jadwal::where('id', '=', $request->id)->first();
            $lastKodeKelas = $jadwal->kode_kelas;
            
            $jadwal->kegiatan       = $request->kegiatan;
            $jadwal->kode_kelas     = $request->kode_kelas;
            $jadwal->waktu_mulai    = date('Y-m-d H:i:s', strtotime($timeStart));
            $jadwal->created_at     = Carbon::now();
            $jadwal->sistem_penilaian= $request->sistem_penilaian;
            $jadwal->materi_id      = $request->materi_id;
            $jadwal->semester_id    = $request->semester_id;
            
            $matchColumn = ['kode_kelas' => $lastKodeKelas, 'jadwal_id' => $request->id];
            $oldPenilaian = Penilaian::where($matchColumn);

            if($jadwal->save() && $oldPenilaian->delete()){ // save update & clear the old data
                $table = request()->session()->get('table');
                $kelas = Kelas::where('kode_kelas', '=', $request->kode_kelas)->get()->toArray();
                $dtIdSantri = array_map (function($value){
                    return $value['santri_id'];
                    }, $kelas);
                    
                foreach($dtIdSantri as $santriVal){
                    $penilaian = new Penilaian();
                    $penilaian->nilai = 0;
                    $penilaian->presensi = ($request->sistem_penilaian == 'kehadiran') ? 'absen':'hadir';
                    $penilaian->deskripsi = '';
                    $penilaian->kode_kelas = $request->kode_kelas;
                    $penilaian->guru_id = Auth::guard($table)->user()->id;
                    $penilaian->santri_id = $santriVal;
                    $penilaian->jadwal_id = $jadwal->id;
                    $penilaian->created_at = Carbon::now();
                    $penilaian->save();
                }
            }

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data jadwal berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
    public function delete($id){
        $kelas = Jadwal::where('id', '=', $id);
        if($kelas->delete()){
            $result = [
              'status' => 'success',
              'message' =>  'Data jadwal berhasil dihapus'
            ];
          }else{
            $result = [
              'status' => 'error',
              'message' =>  'Data jadwal gagal dihapus :('
            ];
          }
          return redirect()->back()->with($result['status'], $result['message']);
    }
    
}
