<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSantriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('santri', function (Blueprint $table) {
            $table->id();
            $table->string('username',25);
            $table->string('password',255);
            $table->string('nama_santri',35);
            $table->string('email',35)->unique()->nullable();
            $table->string('nomor_hp',16)->nullable();
            $table->enum('tingkatan', ['ula', 'wustho','ulya']);
            $table->string('tempat_lahir',25)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto',50)->nullable();
            $table->boolean('is_pengurus');
            $table->enum('jenis_kelamin', ['laki-laki','perempuan']);
            $table->enum('status_santri', ['aktif','alumni']);
            $table->text('universitas');
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
        Schema::dropIfExists('santri');
    }
}
