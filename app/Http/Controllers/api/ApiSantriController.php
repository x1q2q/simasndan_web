<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SantriResource;
use App\Http\Resources\SantriCollection;
use App\Http\Resources\NotifikasiResource;
use App\Http\Resources\NotifikasiCollection;
use App\Models\Santri;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use \Illuminate\Support\Facades\DB;

class ApiSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = new SantriCollection(Santri::all(),SantriResource::class);
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $santri = Santri::findOrFail($id);
        $response = new SantriResource($santri);
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        $hasFile = $request->hasFile('image');
        $file    = $request->image;
        $uname   = $request->username;
        $fotoName = $this->uploadFile($hasFile,$file,$uname);
        $updateFields = [
            'nama_santri'   => $request->nama_santri,
            'tempat_lahir'  => $request->tempat_lahir,
            'tgl_lahir'     => date('Y-m-d',strtotime($request->tgl_lahir)),
            'universitas'   => $request->universitas,
            'alamat'        => $request->alamat,
            'id'            => $request->id,
        ];
        if($fotoName!=null){
            $updateFields['foto'] = $fotoName;
        }
        $santri->update($updateFields);
        return response()->json(["data" => [
            "success" => true,
            "request" => $request->all(),
        ]]);
    }
    public function uploadFile($hasFile, $file, $uname){
        $fotoName = '-';
        if ($hasFile) {
            $dir = '/assets/img/uploads/santri/';
            $content_directory = public_path($dir);
            if(!File::exists($content_directory)) {
                File::makeDirectory($content_directory, $mode = 0777, true, true);
            }

            $foto = $file;
            $slug = str_replace(' ', '-', strtolower($uname));
            $fotoName = "santri_".$slug."_".time().".".$foto->getClientOriginalExtension();
            $foto->move($content_directory, $fotoName);

        }else {
          $fotoName = NULL;
        }
        return $fotoName;
    }
    public function checkUUID($uuid)
    {
        $santri = Santri::where('uuid', '=', $uuid)->first();
        $response = new SantriResource($santri);
        return response()->json(["data" => $response]);
    }
    public function updateUUID(Request $request, $idSantri)
    {
        $updateFields = [
            'fcm_token' => $request->fcm_token
        ];
        if($request->email != null && $request->uuid != null){
            $updateFields['email'] = $request->email;
            $updateFields['uuid'] = $request->uuid;
        }
        $santri = Santri::where('id', '=', $idSantri)->first();
        $santri->update($updateFields);
        $response = new SantriResource($santri);
        return response()->json(["data" => $response]);
    }
    public function getNotifikasi($id){
        $query = Notifikasi::select('grup_notifikasi.santri_id', DB::raw('DATE(notifikasi.created_at) as tanggal'))
        ->join('grup_notifikasi', 'notifikasi.id', '=', 'grup_notifikasi.notif_id')
        ->where('grup_notifikasi.santri_id','=',$id)->orderBy('created_at','desc')->groupBy('tanggal')->get();
        $response = new NotifikasiCollection($query,NotifikasiResource::class);
        return response()->json($response);
    }
    

}
