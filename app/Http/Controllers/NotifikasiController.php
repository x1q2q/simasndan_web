<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;
use App\Models\GrupNotifikasi;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\Santri;
use App\Models\Kelas;

class NotifikasiController extends Controller
{
    public $messaging;
    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(base_path().'/firebase_credentials.json')->withProjectId('simasndan-auth');
        $this->messaging = $factory->createMessaging();
    }
    public function index(){
        $table = request()->session()->get('table');
        $data = array(
            'nama' => Auth::guard($table)->user()->username,
            'role' => request()->session()->get('role')
        );
        return view('panels.data_notifikasi', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $beritaLists = Notifikasi::select('*')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('judul', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('pesan', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('tipe', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('created_at', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($beritaLists)->addIndexColumn()->toJson();
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'pesan' => 'required',
            'tipe' => 'required',
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data notifikasi gagal dimasukkan'
              ];
        }else{
            $notifikasi = new Notifikasi();
            $notifikasi->judul = $request->judul;
            $notifikasi->pesan = $request->pesan;
            $notifikasi->tipe = $request->tipe;
            $notifikasi->created_at = now();  
            if($notifikasi->save()){
                $santris = $request->santri_data;
                $santriIds = ($request->tipe_audiens == 'santri') ? $santris : $this->getSantriIdsFromKelas($request->kode_kelas);
                foreach($santriIds as $val){
                    $grupNotif = new GrupNotifikasi();
                    $grupNotif->notif_id = $notifikasi->id;
                    $grupNotif->santri_id = (int) $val;
                    $grupNotif->save();
                }
                $sendNotif = $this->sendNotif($request->judul,$request->pesan, $santriIds);
            }

            $result = [
                'status' => 200,
                'data'   => $sendNotif,
                'message'=> 'Data notifikasi berhasil dimasukkan'
            ];
        }

        return response()->json($result);
    }
    public function sendNotif($title, $body, $selectedIds){
        $santriFCM = Santri::select('fcm_token')->whereIn('id',$selectedIds)->where('fcm_token', '!=', null)->get()->toArray();
        $deviceTokens = array_map (function($value){
            return $value["fcm_token"];
            }, $santriFCM);

        $imageUrl = 'http://lorempixel.com/400/200/';
        $notification = Notification::fromArray([
            'title' => $title,
            'body' => $body,
            'image' => $imageUrl,
        ]);
        $notification = Notification::create($title, $body);

        $newMessage =CloudMessage::new()->withNotification($notification)->withData(['screen' => '/notifikasi-screen']);  
        $report = $this->messaging->sendMulticast($newMessage,$deviceTokens);  
        foreach ($report->unknownTokens() as $unknownToken) {
            return $unknownToken. " token tidak diketahui";
        }
        
        foreach ($report->invalidTokens() as $invalidToken) {
            return $invalidToken. " token invalid";
        }
        return "berhasil";
    }
    public function getSantriIdsFromKelas($kodeKelas){
        // get santri id from kelas and filtered where fcm_token != null
        $santri = Kelas::select('santri_id')->where('kode_kelas','=',$kodeKelas)->get()->toArray();
        $santriIds = array_map (function($value){
            return $value["santri_id"];
            }, $santri);
        $filteredSantri = Santri::whereIn('id',$santriIds)->where('fcm_token', '!=', null)->pluck('id')->toArray();
        return $filteredSantri;
    }
}
