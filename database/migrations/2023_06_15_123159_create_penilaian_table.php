<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->enum('sistem_penilaian',['kehadiran','nilai']);
            $table->integer('nilai');
            $table->unsignedBigInteger('materi_id');
            $table->enum('presensi',['hadir','absen']);
            $table->text('deskripsi');
            $table->string('tahun_pelajaran',15);
            $table->enum('semester',['genap','ganjil']);
            $table->string('kode_kelas',15);
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('santri_id');
            $table->timestamp('created_at');
            $table->foreign('materi_id')->references('id')->on('materi')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->foreign('santri_id')->references('id')->on('santri')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian');
    }
}
