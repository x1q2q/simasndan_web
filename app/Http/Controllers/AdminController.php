<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index(){
        $data = $this->getDataBasics();
        return view('panels.data_admin', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $adminLists = Admin::select('*')
            ->where(function ($query) use ($post) {
                if ($post["s_status"] != 'all') {
                    $query->where('is_pengasuh', $post["s_status"]);
                }})
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('nama_admin', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('username', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($adminLists)->addIndexColumn()->toJson();
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:25',
            'password' => 'required|min:3',
            'nama_admin' => 'required',
            'is_pengasuh' => 'required',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data admin gagal dimasukkan'
              ];
        }else{
            $hasFile = $request->hasFile('foto');
            $file    = $request->foto;
            $uname   = $request->username;
            $fotoName = $this->uploadFile($hasFile,$file,$uname);

            $admin = new admin();
            $admin->username     = $request->username;
            $admin->password     = Hash::make($request->password);
            $admin->nama_admin = $request->nama_admin;
            $admin->is_pengasuh = $request->is_pengasuh;
            $admin->foto         = $fotoName;
            $admin->created_at = now();        
            $admin->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data admin berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
    public function detail($id){
        $data['admin'] = Admin::where('id', '=', $id)->first();;
        return json_encode($data);
    }
    public function update(Request $request){
        $attrValidate = [
            'username' => 'required|max:25',
            'nama_admin' => 'required',
            'is_pengasuh' => 'required',
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
                'message'=> 'Data admin gagal diupdate'
              ];
        }else{
            $id = $request->id;
            $admin = Admin::where('id','=', $id)->first();
            $fotoName = $admin->foto;
            if(!empty($request->password)){
                $admin->password     = Hash::make($request->password);
            }
            if($admin->foto != $request->foto_file_name){
                $hasFile = $request->hasFile('foto');
                $file    = $request->foto;
                $uname   = $request->username;
                $fotoName = $this->uploadFile($hasFile,$file, $uname);
            }

            $admin->username     = $request->username;
            $admin->password     = Hash::make($request->password);
            $admin->nama_admin = $request->nama_admin;
            $admin->is_pengasuh = $request->is_pengasuh;
            $admin->foto         = $fotoName;
            $admin->created_at = now();
            $admin->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data admin berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
    public function delete($id){
        $admin = Admin::where('id', '=', $id);
        if($admin->delete()){
            $result = [
              'status' => 'success',
              'message' =>  'Data admin berhasil dihapus'
            ];
          }else{
            $result = [
              'status' => 'error',
              'message' =>  'Data admin gagal dihapus :('
            ];
          }
          return redirect()->back()->with($result['status'], $result['message']);
    }
    public function uploadFile($hasFile, $file, $uname){
        if ($hasFile) {
            $content_directory = public_path('/assets/img/uploads/admin/');
            if(!File::exists($content_directory)) {
                File::makeDirectory($content_directory, $mode = 0777, true, true);
            }
            $foto = $file;
            $slug = str_replace(' ', '-', strtolower($uname));
            $fotoName = "adm_".$slug."_".time().".".$foto->getClientOriginalExtension();
            $foto->move($content_directory, $fotoName);
        }else {
          $fotoName = NULL;
        }
        return $fotoName;
    }
}
