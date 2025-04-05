<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Survey extends Model
{
    use HasFactory;
    protected $table = 'surveys';
    protected $fillable = [
        'pertanyaan',
        'kategori_jawaban',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    public function kategoriJawaban()
    {
        return $this->belongsTo(KategoriJawaban::class);
    }

    public function pilihanJawaban()
    {
        return $this->hasMany(PilihanJawaban::class);
    }
}
