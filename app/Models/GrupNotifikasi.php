<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupNotifikasi extends Model
{
    use HasFactory;
    protected $table = 'grup_notifikasi';
    protected $guarded = ['id'];
    public $timestamps = false;
}
