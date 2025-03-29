<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJawaban extends Model
{
    use HasFactory;
    protected $table = 'kategori_jawaban';

    protected $fillable = [
        'nama_kategori',
    ];

    public function skalaJawaban()
    {
        return $this->hasMany(SkalaJawaban::class);
    }
}
