<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    public function index(){
        $table = request()->session()->get('table');
        $data = array(
            'nama' => Auth::guard($table)->user()->username,
            'role' => request()->session()->get('role')
        );
        return view('panels.data_penilaian', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $beritaLists = Penilaian::select('penilaian.*','santri.nama_santri','jadwal.kegiatan','guru.nama_guru')
            ->join('santri', 'penilaian.santri_id', '=', 'santri.id')
            ->join('jadwal', 'penilaian.jadwal_id', '=', 'jadwal.id')
            ->join('guru', 'penilaian.guru_id', '=', 'guru.id')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('kegiatan', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('kode_kelas', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('waktu_mulai', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('created_at', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($beritaLists)->addIndexColumn()->toJson();
    }
    public function detail($id){
        $data['penilaian'] = Penilaian::where('id', '=', $id)->first();
        return json_encode($data);
    }
    public function update(Request $request){
        $attrValidate = [
            'nilai' => 'required',
            'presensi' => 'required'
        ];
        $validator = Validator::make($request->all(), $attrValidate);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data penilaian gagal diupdate'
              ];
        }else{
            $table = request()->session()->get('table');
            $id = $request->id;
            $penilaian = Penilaian::where('id','=', $id)->first();

            $penilaian->nilai = $request->nilai;
            $penilaian->presensi = $request->presensi;
            $penilaian->deskripsi = $request->deskripsi;
            $penilaian->guru_id = Auth::guard($table)->user()->id;
            $penilaian->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data penilaian berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
}
