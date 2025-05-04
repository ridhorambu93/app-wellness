<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkalaJawaban extends Model
{
    use HasFactory;
    protected $table = 'skala_jawaban';

    protected $fillable = [
        'id_kategori_jawaban',
        'nama_skala',
        'nilai',
    ];

    public function kategoriJawaban()
    {
        return $this->belongsTo(KategoriJawaban::class, 'id_kategori_jawaban', 'id');
    }
}
