<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){
        $table = request()->session()->get('table');
        $data = array(
            'nama'          => Auth::guard($table)->user()->username,
            'nama_lengkap'  => $this->getNamaLengkap($table),
            'role'          => request()->session()->get('role')
        );
        return view('panels/dashboard', $data);
    }
    public function restricted($role){
        $data = array(
            'from'      => $role
        );
        return view('panels/restrict',$data);
    }
    public function getNamaLengkap($table){ // santri, admin, guru
        $namaLengkap = '';
        if($table == 'santri'){
            $namaLengkap = Auth::guard($table)->user()->nama_santri;
        }else if($table == 'guru'){
            $namaLengkap = Auth::guard($table)->user()->nama_guru;
        }else{ // admin
            $namaLengkap = Auth::guard($table)->user()->nama_admin;
        }
        return $namaLengkap;
    }

}
