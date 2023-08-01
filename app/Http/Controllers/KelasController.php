<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\Santri;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index(){
        $table = request()->session()->get('table');
        $data = array(
            'nama' => Auth::guard($table)->user()->username,
            'role' => request()->session()->get('role')
        );
        return view('panels.data_kelas', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $beritaLists = Kelas::select(DB::raw("GROUP_CONCAT(DISTINCT santri.nama_santri SEPARATOR ', ') as santri_data"),'kelas.*')
        ->join('santri', 'kelas.santri_id', '=', 'santri.id')
        ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('nama_kelas', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('kode_kelas', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
        }})->orderBy('id','desc')->groupBy('kode_kelas');

        return \DataTables::eloquent($beritaLists)->addIndexColumn()->toJson();
    }
    public function getSantriData(){
        $santri = Santri::all()->toArray();
        return json_encode($santri);
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'kode_kelas' => 'required',
            'nama_kelas' => 'required',
            'santri_data' => 'required',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data kelas gagal dimasukkan'
              ];
        }else{
            
            $santris = $request->santri_data;
            foreach($santris as $value){
                $kelas = new Kelas();
                $kelas->kode_kelas = $request->kode_kelas;
                $kelas->nama_kelas = $request->nama_kelas;
                $kelas->santri_id = (int)$value;
                $kelas->save();
            }

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data kelas berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
    public function detail($kode){
        $kelas = Kelas::where('kode_kelas', '=', $kode)->get()->toArray();
        $dtIdSantri = array_map (function($value){
            return $value['santri_id'];
            }, $kelas);
        $newData = [
            'kode_kelas' => $kelas[0]['kode_kelas'],
            'nama_kelas' => $kelas[0]['nama_kelas'],
            'list_santri'=> $dtIdSantri
        ];
        $data['kelas'] = $newData;
        return json_encode($data);
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'kode_kelas' => 'required',
            'nama_kelas' => 'required',
            'santri_data' => 'required',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data kelas gagal diupdate'
              ];
        }else{
            // clear all old data (kode_kelas)
            $oldKelas = Kelas::where('kode_kelas', '=', $request->kode_kelas);
            if($oldKelas->delete()){
                $santris = $request->santri_data;
                foreach($santris as $value){
                    $kelas = new Kelas();
                    $kelas->kode_kelas = $request->kode_kelas;
                    $kelas->nama_kelas = $request->nama_kelas;
                    $kelas->santri_id = (int)$value;
                    $kelas->save();
                }
            }

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data kelas berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
    public function delete($kode){
        $kelas = Kelas::where('kode_kelas', '=', $kode);
        if($kelas->delete()){
            $result = [
              'status' => 'success',
              'message' =>  'Data kelas berhasil dihapus'
            ];
          }else{
            $result = [
              'status' => 'error',
              'message' =>  'Data kelas gagal dihapus :('
            ];
          }
          return redirect()->back()->with($result['status'], $result['message']);
    }
}
