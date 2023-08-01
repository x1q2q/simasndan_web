<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function index(){
        $table = request()->session()->get('table');
        $data = array(
            'nama' => Auth::guard($table)->user()->username,
            'role' => request()->session()->get('role')
        );
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
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required',
            'kode_kelas' => 'required',
            'sistem_penilaian' => 'required',
            'materi_id' => 'required',
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
            
            $kodes = $request->kode_kelas;
            foreach($kodes as $value){
                $jadwal = new Jadwal();
                $jadwal->kegiatan       = $request->kegiatan;
                $jadwal->kode_kelas     = $value;
                $jadwal->waktu_mulai    = now();
                $jadwal->created_at     = now();
                $jadwal->sistem_penilaian= $request->sistem_penilaian;
                $jadwal->materi_id      = $request->materi_id;
                $jadwal->save();
            }

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data jadwal berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
}
