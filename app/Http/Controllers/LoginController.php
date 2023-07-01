<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);
        $sel_role = $request->role;
        $table = $sel_role == 1 ? 'santri' : ($sel_role == 3 || $sel_role == 4 ? 'admin' : 'guru');
 
        if (Auth::guard($table)->attempt($credentials)) {
            if($table == 'santri'){
                if(Auth::guard('santri')->user()->is_pengurus == 0){
                    return redirect()->back()->with('error', 'login gagal. anda tidak memiliki wewenang sebagai pengurus!');
                }else if(Auth::guard('santri')->user()->status_santri == 'alumni'){
                    return redirect()->back()->with('error', 'login gagal. anda sudah berstatus sebagai alumni!');
                }
            }
            $request->session()->regenerate();
            $request->session()->put('table', $table);
            $request->session()->put('role', $this->getRole($sel_role));
            return redirect()->intended('/dashboard');
        }
 
        return redirect()->back()->with('error', 'login gagal. username atau password salah!');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->forget('table');
        $request->session()->forget('role');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function getRole($id){
        switch ($id) {
            case '1':
                return 'pengurus';
                break;
            case '2':
                return 'guru';
                break;
            case '3':
                return 'admin';
                break;
            default:
                return 'pengasuh';
                break;
        }
    }
}
