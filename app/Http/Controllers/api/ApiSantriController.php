<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SantriResource;
use App\Http\Resources\SantriCollection;
use App\Models\Santri;
use Illuminate\Http\Request;


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
        $santri->update([
            'nama_santri'   => $request->nama_santri,
            'tempat_lahir'  => $request->tempat_lahir,
            'tgl_lahir'     => date('Y-m-d',strtotime($request->tgl_lahir)),
            'universitas'   => $request->universitas,
            'alamat'        => $request->alamat,
            'id'            => $request->id,
            'foto'          => $request->foto
        ]);
        return response()->json(["data" => [
            "success" => true,
            "request" => $santri
        ]]);
    }
}
