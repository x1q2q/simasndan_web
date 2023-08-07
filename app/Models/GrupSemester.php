<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupSemester extends Model
{
    use HasFactory;
    protected $table = 'grup_semester';
    protected $guarded = ['id'];
    public $timestamps = false;
}
