<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Santri;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SantriController extends Controller
{
    public function index(){
        $table = request()->session()->get('table');
        $data = array(
            'nama' => Auth::guard($table)->user()->username,
            'role' => request()->session()->get('role')
        );
        return view('panels.data_santri', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $santriLists = Santri::select('*')
            ->where(function ($query) use ($post) {
                if ($post["s_status"] != 'all') {
                    $query->where('tingkatan', $post["s_status"]);
                }})
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('nama_santri', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('username', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('alamat', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('created_at','desc');

        return \DataTables::eloquent($santriLists)->addIndexColumn()->toJson();
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:15',
            'password' => 'required|min:5',
            'is_pengurus' => 'required',
            'jenis_kelamin' => 'required',
            'tingkatan' => 'required',
            'nama_santri' => 'required|max:30',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data santri gagal dimasukkan'
              ];
        }else{
            $santri = new Santri();
            $santri->username     = $request->username;
            $santri->password     = Hash::make($request->password);
            $santri->email        = null;
            $santri->nomor_hp     = '-';
            $santri->tempat_lahir = '-';
            $santri->tgl_lahir    = null;
            $santri->foto         = '-';
            $santri->status_santri= 'aktif';
            $santri->is_pengurus = $request->is_pengurus;
            $santri->nama_santri = $request->nama_santri;
            $santri->jenis_kelamin = $request->jenis_kelamin;
            $santri->tingkatan = $request->tingkatan;
            $santri->alamat = $request->alamat;
            $santri->universitas  = '-';
            $santri->created_at = now();
            $santri->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data santri berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
    public function detail($id){
        $data['santri'] = Santri::where('id', '=', $id)->first();;
        return json_encode($data);
    }
    public function update(Request $request){
        $attrValidate = [
            'username' => 'required|max:15',
            'is_pengurus' => 'required',
            'jenis_kelamin' => 'required',
            'tingkatan' => 'required',
            'nama_santri' => 'required|max:30',
        ];
        if(!empty($request->password)){
            $attrValidate['password'] = 'required|min:5';
        }
        $validator = Validator::make($request->all(), $attrValidate);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data santri gagal diupdate'
              ];
        }else{
            $id = $request->id;
            $santri = Santri::where('id','=', $id)->first();
            $santri->username     = $request->username;
            if(!empty($request->password)){
                $santri->password     = Hash::make($request->password);
            }
            $santri->is_pengurus = $request->is_pengurus;
            $santri->nama_santri = $request->nama_santri;
            $santri->jenis_kelamin = $request->jenis_kelamin;
            $santri->tingkatan = $request->tingkatan;
            $santri->alamat = $request->alamat;
            $santri->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data santri berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
    public function delete($id){
        $santri = Santri::where('id', '=', $id);
        if($santri->delete()){
            $result = [
              'status' => 'success',
              'message' =>  'Data berhasil dihapus'
            ];
          }else{
            $result = [
              'status' => 'error',
              'message' =>  'Data gagal dihapus :('
            ];
          }
          return redirect()->back()->with($result['status'], $result['message']);
    }
}