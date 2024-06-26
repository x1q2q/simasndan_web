<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Berita;

class Media extends Model
{
    use HasFactory;
    protected $table = 'media';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}
