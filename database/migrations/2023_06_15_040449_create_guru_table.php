<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('username',25)->unique();
            $table->string('password',255);
            $table->string('nama_guru',35);
            $table->string('email',35)->unique();
            $table->string('nomor_hp',16)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('tempat_lahir',25)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto',50)->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guru');
    }
}
