<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    use HasFactory;
    protected $table = 'responden'; // Nama tabel jika berbeda
    protected $fillable = [
        'nama',
        'email',
        'id_jawaban_responden',
        'survey_id',
    ];

    public function jawaban()
    {
        return $this->hasMany(JawabanResponden::class, 'id_user', 'id');
    }

    public function jawabanPivot()
    {
        return $this->belongsToMany(JawabanResponden::class, 'responden_jawaban', 'responden_id', 'jawaban_responden_id');
    }
}
