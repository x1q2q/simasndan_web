<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Santri extends Authenticatable
{

    use HasFactory;
    use Notifiable;
    protected $table = 'santri';
    protected $guarded = ['id'];
    public $timestamps = false;
}
