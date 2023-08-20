<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupNotifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grup_notifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notif_id');
            $table->unsignedBigInteger('santri_id');
            $table->foreign('notif_id')->references('id')->on('notifikasi')->onDelete('cascade');
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
        Schema::dropIfExists('grup_notifikasi');
    }
}
