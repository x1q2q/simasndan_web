<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul_berita',35);
            $table->enum('kategori_berita',['artikel','pengumuman','jadwal']);
            $table->text('isi_berita');
            $table->unsignedBigInteger('media_id');
            $table->enum('penulis',['admin','pengurus','pengasuh']);
            $table->timestamp('created_at');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berita');
    }
}
