<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Materi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class MateriController extends Controller
{
    public function index(){
        $table = request()->session()->get('table');
        $data = array(
            'nama' => Auth::guard($table)->user()->username,
            'role' => request()->session()->get('role')
        );
        return view('panels.data_materi', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $materiLists = Materi::select('*')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('nama_materi', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('kode_materi', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($materiLists)->addIndexColumn()->toJson();
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_materi' => 'required',
            'kode_materi' => 'required',
            'link_materi' => 'required',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data materi gagal dimasukkan'
              ];
        }else{
            $hasFile = $request->hasFile('foto');
            $file    = $request->foto;
            $uname   = $request->username;
            $fotoName = $this->uploadFile($hasFile,$file,$uname);

            $materi = new Materi();
            $materi->nama_materi = $request->nama_materi;
            $materi->kode_materi = $request->kode_materi;
            $materi->link_materi = $request->link_materi;
            $materi->foto        = $fotoName;
            $materi->deskripsi   = $request->deskripsi;        
            $materi->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data materi berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
    public function detail($id){
        $data['materi'] = Materi::where('id', '=', $id)->first();
        return json_encode($data);
    }
    public function update(Request $request){
        $attrValidate = [
            'nama_materi' => 'required',
            'kode_materi' => 'required',
            'link_materi' => 'required',
        ];
        $validator = Validator::make($request->all(), $attrValidate);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data materi gagal diupdate'
              ];
        }else{
            $id = $request->id;
            $materi = Materi::where('id','=', $id)->first();
            $fotoName = $materi->foto;
            if($materi->foto != $request->foto_file_name){
                $hasFile = $request->hasFile('foto');
                $file    = $request->foto;
                $uname   = $request->username;
                $fotoName = $this->uploadFile($hasFile,$file, $uname);
            }

            $materi->nama_materi = $request->nama_materi;
            $materi->kode_materi = $request->kode_materi;
            $materi->link_materi = $request->link_materi;
            $materi->foto        = $fotoName;
            $materi->deskripsi   = $request->deskripsi; 
            $materi->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data materi berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
    public function delete($id){
        $materi = Materi::where('id', '=', $id);
        if($materi->delete()){
            $result = [
              'status' => 'success',
              'message' =>  'Data materi berhasil dihapus'
            ];
          }else{
            $result = [
              'status' => 'error',
              'message' =>  'Data materi gagal dihapus :('
            ];
          }
          return redirect()->back()->with($result['status'], $result['message']);
    }
    public function uploadFile($hasFile, $file, $uname){
        if ($hasFile) {
            $content_directory = public_path('/assets/img/uploads/materi/');
            if(!File::exists($content_directory)) {
                File::makeDirectory($content_directory, $mode = 0777, true, true);
            }
            $foto = $file;
            $slug = str_replace(' ', '-', strtolower($uname));
            $fotoName = "mtr_".$slug."_".time().".".$foto->getClientOriginalExtension();
            $foto->move($content_directory, $fotoName);
        }else {
          $fotoName = NULL;
        }
        return $fotoName;
    }
}
