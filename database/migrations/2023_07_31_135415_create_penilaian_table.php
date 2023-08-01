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
            $table->integer('nilai');
            $table->enum('presensi',['hadir','absen']);
            $table->text('deskripsi');
            $table->string('kode_kelas',15);
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('santri_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->timestamp('created_at');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->foreign('santri_id')->references('id')->on('santri')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semester')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semester');
    }
}
