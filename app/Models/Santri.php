<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Santri extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'santri';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function kelas(){
        return $this->hasMany(Kelas::class);
    }
}
