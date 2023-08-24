<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\DB;

class AbsenkanController extends Controller
{
    public function index($id){
        $detailJadwal = app('App\Http\Controllers\JadwalController')->detail($id);
        $penilaians = Penilaian::select('penilaian.*','santri.nama_santri')
                        ->join('santri', 'penilaian.santri_id', '=', 'santri.id')
                        ->where('jadwal_id','=',$id)->get();
        $data = $this->getDataBasics();
        $data['jadwal'] = json_decode($detailJadwal)->jadwal;
        $data['penilaian'] = $penilaians;
        return view('panels.absenkan', $data);
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            // 'deskripsi' => 'required',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data absensi gagal diupdate'
              ];
        }else{
            $id = $request->id;
            $penilaian = Penilaian::where('id','=',$id)->first();
            $sistemPenilaian = $request->sistem_penilaian;
            if($sistemPenilaian == 'kehadiran'){
                $penilaian->presensi = $request->nilai;
                $penilaian->nilai = ($request->nilai == 'absen') ? 0 : 100;
            }else if($sistemPenilaian == 'nilai'){
                $penilaian->nilai = $request->nilai;
                $penilaian->presensi = ($request->nilai > 0) ? 'hadir':'absen';
            }
            $penilaian->deskripsi = $request->deskripsi;   
            $penilaian->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data absensi berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
    public function updateAll(Request $request){
        $data = $request['data'];
        if(DB::table('penilaian')->upsert($data,'id')){
            $result = [
                'status' => 200,
                'message'=> 'Data absensi berhasil diupdate '
            ];
        }else{
            $result = [
                'status' => 500,
                'message'=> 'Data absensi gagal diupdate '
            ];
        }       
        
        return response()->json($result);
    }
}
