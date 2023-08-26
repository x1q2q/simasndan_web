<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Berita;
use App\Models\Media;
use App\Models\Santri;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class BeritaController extends Controller
{
    public function index(){
        $data = $this->getDataBasics();
        return view('panels.data_berita', $data);
    }
    public function lists(Request $request){
        $post = $request->all();
        $beritaLists = Berita::select('*')
            ->where(function ($query) use ($post) {
            if (!empty($post["s_keyword"])) {
                $query->where('judul_berita', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('kategori_berita', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('isi_berita', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%')
                    ->orWhere('penulis', 'LIKE', '%' . strtolower($post["s_keyword"]) . '%');
            }})->orderBy('id','desc');

        return \DataTables::eloquent($beritaLists)->addIndexColumn()->toJson();
    }
    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'judul_berita'      => 'required',
            'kategori_berita'   => 'required',
            'isi_berita'        => 'required',
            'penulis'           => 'required'
        ]);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data berita gagal dimasukkan'
              ];
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $hasFile = $request->hasFile('foto');
            $file    = $request->foto;
            $kategori   = $request->kategori_berita;
            
            $berita = new Berita();
            $berita->judul_berita       = $request->judul_berita;
            $berita->kategori_berita    = $kategori;
            $berita->isi_berita         = $request->isi_berita;
            $berita->penulis            = $request->penulis;
            $berita->created_at         = Carbon::now();  
            $berita->save();
            if($hasFile){
                $fotoName = $this->uploadFile($hasFile,$file,$kategori);
                $media = new Media();
                $media->type_media = 'gambar';
                $media->nama       = $fotoName;
                $media->berita_id  = $berita->id;
                $media->save();
            }
            
            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data berita berhasil dimasukkan '
            ];
            if($request->kategori_berita == 'jadwal' || $request->kategori_berita == 'pengumuman'){
                $allSantri = Santri::where('fcm_token','!=',null)->pluck('id')->toArray();
                $notifsData = [
                    'judul' => $request->judul_berita,
                    'pesan'  => 'Ada '.$request->kategori_berita.' terbaru oleh '.$request->penulis,
                    'tipe'  => $request->kategori_berita,
                    'selected' => $allSantri,
                ];
                $sendNotif = app('App\Http\Controllers\NotifikasiController')->sendNotifications($notifsData);
                
                if($sendNotif == 'berhasil'){
                    $result['message'] =  $result['message']. ' & notifikasi berhasil  dikirimkan';
                }else{
                    $result['message'] =  $result['message'].' namun token '.$sendNotif;
                }
            }
        }

        return response()->json($result);
    }
    public function detail($id){
        $data['berita'] = Berita::leftJoin('media','berita.id','=','media.berita_id')
                            ->where('berita.id', '=', $id)->get(['berita.*', 'media.nama'])->first();
        return json_encode($data);
    }
    public function update(Request $request){
        $attrValidate = [
            'judul_berita'      => 'required',
            'kategori_berita'   => 'required',
            'isi_berita'        => 'required',
            'penulis'           => 'required'
        ];
        $validator = Validator::make($request->all(), $attrValidate);
        if($validator->fails()){
            $msg_errors = $validator->errors();
            $result = [
                'status' => 500,
                'data'   => $msg_errors,
                'message'=> 'Data berita gagal diupdate'
              ];
        }else{
            $id = $request->id;
            $hasFile = $request->hasFile('foto');
            $file    = $request->foto;
            $kategori   = $request->kategori_berita;
            $berita = Berita::where('id','=', $id)->first();
            $berita->judul_berita   = $request->judul_berita;
            $berita->kategori_berita    = $kategori;
            $berita->isi_berita = $request->isi_berita;
            $berita->penulis     = $request->penulis;       
            $berita->save();
            if($hasFile){
                $fotoName = $this->uploadFile($hasFile,$file,$kategori);
                $media =Media::where('berita_id','=', $id)->first();
                if($media == null){
                    $media = new Media();
                }
                $media->berita_id = $id;
                $media->type_media = 'gambar';
                $media->nama       = $fotoName;
                $media->ekstensi   = $file->getClientOriginalExtension();
                $media->save();
            }

            $result = [
                'status' => 200,
                'data'   => $request,
                'message'=> 'Data berita berhasil diupdate'
            ];
        }

        return response()->json($result);
    }
    public function delete($id){
        $berita = Berita::where('id', '=', $id);
        if($berita->delete()){
            $result = [
              'status' => 'success',
              'message' =>  'Data berita berhasil dihapus'
            ];
          }else{
            $result = [
              'status' => 'error',
              'message' =>  'Data berita gagal dihapus :('
            ];
          }
          return redirect()->back()->with($result['status'], $result['message']);
    }
    public function uploadFile($hasFile, $file, $uname){
        if ($hasFile) {
            $content_directory = public_path('/assets/img/uploads/berita/');
            if(!File::exists($content_directory)) {
                File::makeDirectory($content_directory, $mode = 0777, true, true);
            }
            $foto = $file;
            $slug = str_replace(' ', '-', strtolower($uname));
            $fotoName = "news_".$slug."_".time().".".$foto->getClientOriginalExtension();
            $foto->move($content_directory, $fotoName);
        }else {
          $fotoName = NULL;
        }
        return $fotoName;
    }
}
