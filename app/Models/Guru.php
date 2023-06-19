<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guru extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected $table = 'guru';
    protected $guarded = ['id'];
    public $timestamps = false;
}
