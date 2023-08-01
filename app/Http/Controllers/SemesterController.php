<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    public function index(){
        $table = request()->session()->get('table');
        $data = array(
            'nama' => Auth::guard($table)->user()->username,
            'role' => request()->session()->get('role')
        );
        return view('panels.data_semester', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $beritaLists = Semester::select('*')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('semester', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('tahun_pelajaran', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($beritaLists)->addIndexColumn()->toJson();
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'semester' => 'required',
            'tahun_pelajaran' => 'required',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data semester gagal dimasukkan'
              ];
        }else{
            $semester = new Semester();
            $semester->semester = $request->semester;
            $semester->tahun_pelajaran = $request->tahun_pelajaran;   
            $semester->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data semester berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
    public function detail($id){
        $data['semester'] = Semester::where('id', '=', $id)->first();
        return json_encode($data);
    }
    public function update(Request $request){
        $attrValidate = [
            'semester' => 'required',
            'tahun_pelajaran' => 'required'
        ];
        $validator = Validator::make($request->all(), $attrValidate);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data semester gagal diupdate'
              ];
        }else{
            $id = $request->id;
            $semester = Semester::where('id','=', $id)->first();

            $semester->semester = $request->semester;
            $semester->tahun_pelajaran = $request->tahun_pelajaran;
            $semester->save();

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data semester berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
    public function delete($id){
        $semester = Semester::where('id', '=', $id);
        if($semester->delete()){
            $result = [
              'status' => 'success',
              'message' =>  'Data semester berhasil dihapus'
            ];
          }else{
            $result = [
              'status' => 'error',
              'message' =>  'Data semester gagal dihapus :('
            ];
          }
          return redirect()->back()->with($result['status'], $result['message']);
    }
}
