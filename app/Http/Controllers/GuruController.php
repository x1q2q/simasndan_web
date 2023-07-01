<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class GuruController extends Controller
{
    public function index(){
        $table = request()->session()->get('table');
        $data = array(
            'nama' => Auth::guard($table)->user()->username,
            'role' => request()->session()->get('role')
        );
        return view('panels.data_guru', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $guruLists = Guru::select('*')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('nama_guru', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('username', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('email', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($guruLists)->addIndexColumn()->toJson();
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:25',
            'password' => 'required|min:3',
            'nama_guru' => 'required',
            'email' => 'required',
            'nomor_hp' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data guru gagal dimasukkan'
              ];
        }else{
            $hasFile = $request->hasFile('foto');
            $file    = $request->foto;
            $uname   = $request->username;
            $fotoName = $this->uploadFile($hasFile,$file,$uname);

            $guru = new Guru();
            $guru->username     = $request->username;
            $guru->password     = Hash::make($request->password);
            $guru->nama_guru    = $request->nama_guru;
            $guru->email        = $request->email;
            $guru->nomor_hp     = $request->nomor_hp;
            $guru->tempat_lahir = $request->tempat_lahir;
            $guru->tgl_lahir    = $request->tgl_lahir;
            $guru->foto         = $fotoName;
            $guru->alamat       = $request->alamat;
            $guru->created_at = now();        
            $guru->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data guru berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
    public function detail($id){
        $data['guru'] = Guru::where('id', '=', $id)->first();;
        return json_encode($data);
    }
    public function update(Request $request){
        $attrValidate = [
            'username' => 'required|max:25',
            'nama_guru' => 'required',
            'email' => 'required',
            'nomor_hp' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
        ];
        if(!empty($request->password)){
            $attrValidate['password'] = 'required|min:3';
        }
        $validator = Validator::make($request->all(), $attrValidate);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data guru gagal diupdate'
              ];
        }else{
            $id = $request->id;
            $guru = Guru::where('id','=', $id)->first();
            $fotoName = $guru->foto;
            if(!empty($request->password)){
                $guru->password     = Hash::make($request->password);
            }
            if($guru->foto != $request->foto_file_name){
                $hasFile = $request->hasFile('foto');
                $file    = $request->foto;
                $uname   = $request->username;
                $fotoName = $this->uploadFile($hasFile,$file, $uname);
            }

            $guru->username     = $request->username;
            $guru->password     = Hash::make($request->password);
            $guru->nama_guru    = $request->nama_guru;
            $guru->email        = $request->email;
            $guru->nomor_hp     = $request->nomor_hp;
            $guru->tempat_lahir = $request->tempat_lahir;
            $guru->tgl_lahir    = $request->tgl_lahir;
            $guru->foto         = $fotoName;
            $guru->alamat       = $request->alamat;
            $guru->created_at = now();
            $guru->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data guru berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
    public function delete($id){
        $guru = Guru::where('id', '=', $id);
        if($guru->delete()){
            $result = [
              'status' => 'success',
              'message' =>  'Data guru berhasil dihapus'
            ];
          }else{
            $result = [
              'status' => 'error',
              'message' =>  'Data guru gagal dihapus :('
            ];
          }
          return redirect()->back()->with($result['status'], $result['message']);
    }
    public function uploadFile($hasFile, $file, $uname){
        if ($hasFile) {
            $content_directory = public_path('/assets/img/uploads/guru/');
            if(!File::exists($content_directory)) {
                File::makeDirectory($content_directory, $mode = 0777, true, true);
            }
            $foto = $file;
            $slug = str_replace(' ', '-', strtolower($uname));
            $fotoName = "gr_".$slug."_".time().".".$foto->getClientOriginalExtension();
            $foto->move($content_directory, $fotoName);
        }else {
          $fotoName = NULL;
        }
        return $fotoName;
    }
}
