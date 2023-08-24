<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function getDataBasics(){
        $table = request()->session()->get('table');
        return [
            'nama'          => Auth::guard($table)->user()->username,
            'nama_lengkap'  => $this->getNamaLengkap($table),
            'role'          => request()->session()->get('role'),
            'navs'          => $this->getMenuNavigationsList(),
        ];
    }
    protected function getNamaLengkap($table){ // santri, admin, guru
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
    protected function getMenuNavigationsList(){
        $role = request()->session()->get('role');
        $menus = array(
            array(
                'key'  => '0',
                'type' => 'header',
                'val'  => 'Umum'
            ),
            array(
                'key'       => '1',
                'type'      => 'navs',
                'val'       => 'Dashboard',
                'is_active' => (request()->is('dashboard')) ? 'active' : '',
                'route'     => route('dashboard'),
                'menu_icons'=> 'bx-stats'
            ),
            array(
                'key'       => '2',
                'type'      => 'navs',
                'val'       => 'Data Santri',
                'is_active' => (request()->is('data-santri')) ? 'active' : '',
                'route'     => route('santri'),
                'menu_icons'=> 'bx-face'
            ),
            array(
                'key'       => '3',
                'type'      => 'navs',
                'val'       => 'Data Admin',
                'is_active' => (request()->is('data-admin')) ? 'active' : '',
                'route'     => route('admin'),
                'menu_icons'=> 'bxs-face-mask'
            ),
            array(
                'key'       => '4',
                'type'      => 'navs',
                'val'       => 'Data Berita',
                'is_active' => (request()->is('data-berita')) ? 'active' : '',
                'route'     => route('berita'),
                'menu_icons'=> 'bxs-news'
            ),
            array(
                'key'       => '5',
                'type'      => 'navs',
                'val'       => 'Data Materi',
                'is_active' => (request()->is('data-materi')) ? 'active' : '',
                'route'     => route('materi'),
                'menu_icons'=> 'bx-notepad'
            ),
            array(
                'key'       => '6',
                'type'      => 'navs',
                'val'       => 'Data Guru',
                'is_active' => (request()->is('data-guru')) ? 'active' : '',
                'route'     => route('guru'),
                'menu_icons'=> 'bxs-group'
            ),
            array(
                'key'       => '7',
                'type'      => 'navs',
                'val'       => 'Data Semester',
                'is_active' => (request()->is('data-semester')) ? 'active' : '',
                'route'     => route('semester'),
                'menu_icons'=> 'bx-align-justify'
            ),
            array(
                'key'       => '8',
                'type'      => 'navs',
                'val'       => 'Data Notifikasi',
                'is_active' => (request()->is('data-notifikasi')) ? 'active' : '',
                'route'     => route('notifikasi'),
                'menu_icons'=> 'bxs-bell'
            ),
            array(
                'key'  => '9',
                'type' => 'header',
                'val'  => 'Absensi'
            ),
            array(
                'key'       => '10',
                'type'      => 'navs',
                'val'       => 'Data Jadwal',
                'is_active' => (request()->is('data-jadwal*')) ? 'active' : '',
                'route'     => route('jadwal'),
                'menu_icons'=> 'bxs-chalkboard'
            ),
            array(
                'key'       => '11',
                'type'      => 'navs',
                'val'       => 'Data Kelas',
                'is_active' => (request()->is('data-kelas')) ? 'active' : '',
                'route'     => route('kelas'),
                'menu_icons'=> 'bx-grid'
            ),
            array(
                'key'       => '12',
                'type'      => 'navs',
                'val'       => 'Data Penilaian',
                'is_active' => (request()->is('data-penilaian')) ? 'active' : '',
                'route'     => route('penilaian'),
                'menu_icons'=> 'bxs-food-menu'
            ));
        
        $newMenus = [];
        $keyId = [];
        switch ($role) {
            case 'admin':
                $keyId = array(0,1,2,3,4,5,6,7,8,9,10,11,12);
                break;
            
            case 'pengasuh':
                $keyId = array(0,1,2,4,5,6);
                break;

            case 'pengurus':
                $keyId = array(0,1,2,4,6,8);
                break;
            
            case 'guru':
                $keyId = array(0,1,2,5,7,9,10,11,12);
                break;

            default:
                $keyId = array(0,1);
                break;
        }
        $newMenus = array_filter($menus, function($var, $k) use ($keyId) {
            if(in_array($var["key"],$keyId)){
                return [$k => $var];
            }
        }, ARRAY_FILTER_USE_BOTH);
        return $newMenus;
    }
}
