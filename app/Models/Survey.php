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
        'status_survey'
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
