<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Models\GrupNotifikasi;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\Santri;
use App\Models\Kelas;
use Illuminate\Support\Carbon;
use \Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public $messaging;
    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(base_path().'/firebase_credentials.json')->withProjectId('simasndan-auth');
        $this->messaging = $factory->createMessaging();
    }
    public function index(){
        $data = $this->getDataBasics();
        return view('panels.data_notifikasi', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $beritaLists = Notifikasi::select(DB::raw("GROUP_CONCAT(DISTINCT santri.nama_santri SEPARATOR ', ') as santri_data"),'notifikasi.*')
            ->join('grup_notifikasi', 'notifikasi.id', '=', 'grup_notifikasi.notif_id')
            ->join('santri', 'grup_notifikasi.santri_id', '=', 'santri.id')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('judul', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('pesan', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('tipe', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('created_at', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc')->groupBy('notifikasi.id');;

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
            $santris = $request->santri_data;
            $santriIds = ($request->tipe_audiens == 'santri') ? $santris : $this->getSantriIdsFromKelas($request->kode_kelas);
            $params = [
                'judul'        => $request->judul,
                'pesan'        => $request->pesan,
                'tipe'         => $request->tipe,
                'selected'  => $santriIds
            ];
            $sendNotif = $this->sendNotifications($params);

            $result = [
                'status' => 200,
                'data'   => $sendNotif,
                'message'=> 'Data notifikasi berhasil dimasukkan & '.$sendNotif. ' dikirimkan'
            ];
        }

        return response()->json($result);
    }
    public function sendNotifications($data){
        date_default_timezone_set('Asia/Jakarta');

        $sendNotif = 'gagal';
        $notifikasi = new Notifikasi();
        $notifikasi->judul = $data['judul'];
        $notifikasi->pesan = $data['pesan'];
        $notifikasi->tipe = $data['tipe'];
        $notifikasi->created_at = Carbon::now();
        if($notifikasi->save()){
            $santriIds = $data['selected'];
            foreach($santriIds as $val){
                $grupNotif = new GrupNotifikasi();
                $grupNotif->notif_id = $notifikasi->id;
                $grupNotif->santri_id = (int) $val;
                $grupNotif->save();
            }
            $sendNotif = $this->sendToFirebase($data['judul'],$data['pesan'], $santriIds);
        }
        return $sendNotif;
    }
    public function sendToFirebase($title, $body, $selectedIds){
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
