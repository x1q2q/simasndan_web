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
        $beritaLists = Penilaian::select('*')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('kegiatan', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('kode_kelas', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('waktu_mulai', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('created_at', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($beritaLists)->addIndexColumn()->toJson();
    }
}
