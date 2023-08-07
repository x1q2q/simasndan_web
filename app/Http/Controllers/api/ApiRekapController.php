<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SemesterResource;
use App\Http\Resources\SemesterCollection;
use App\Models\Semester;
use App\Http\Resources\PenilaianResource;
use App\Http\Resources\PenilaianCollection;
use App\Models\Jadwal;

class ApiRekapController extends Controller
{
    public function semester($santriId){
        $semester = Semester::select('semester.*')->join('grup_semester', 'semester.id', '=', 'grup_semester.semester_id')
            ->where('grup_semester.santri_id', '=', $santriId)->get(); 
        $response = new SemesterCollection($semester,SemesterResource::class);
        return response()->json($response);
    }

    public function penilaian($santriId, $semtId)
    {
        $matchColumn = ['penilaian.santri_id' => $santriId, 'semester' => $semtId];
        $query = Jadwal::select('penilaian.santri_id','jadwal.semester_id','jadwal.materi_id','materi.nama_materi')
        ->join('penilaian', 'jadwal.id', '=', 'penilaian.jadwal_id')
        ->join('materi', 'jadwal.materi_id', '=', 'materi.id')
        ->join('semester', 'jadwal.semester_id', '=', 'semester.id')
        ->where($matchColumn)->groupBy('jadwal.materi_id')->get();
        $response = new PenilaianCollection($query,PenilaianResource::class);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
