<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Survey extends Model
{
    use HasFactory;
    protected $table = 'surveys';
    protected $fillable = [
        'nama_survey',
        'deskripsi_survey',
        'tanggal_mulai',
        'tanggal_akhir',
        'status_survey',
        'id_kategori_jawaban'
    ];

    public function kategoriJawaban()
    {
        return $this->belongsTo(KategoriJawaban::class, 'id_kategori_jawaban'); // foreign key
    }

    public function pilihanJawaban()
    {
        return $this->hasMany(PilihanJawaban::class);
    }

    // public function pertanyaan()
    // {
    //     return $this->hasMany(Pertanyaan::class);
    // }

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'survey_id', 'id');
    }
}
