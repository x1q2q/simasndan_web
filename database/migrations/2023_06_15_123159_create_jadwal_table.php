<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('kegiatan',25);
            $table->string('kode_kelas',15);
            $table->dateTime('waktu_mulai');
            $table->timestamp('created_at');
            $table->enum('sistem_penilaian',['kehadiran','nilai']);
            $table->unsignedBigInteger('materi_id');
            $table->unsignedBigInteger('semester_id');
            $table->foreign('materi_id')->references('id')->on('materi')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semester')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
}
