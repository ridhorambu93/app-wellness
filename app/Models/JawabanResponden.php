<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanResponden extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_pertanyaan', 'jawaban'];
    protected $table = 'jawaban_responden';

    // Relasi dengan model Pertanyaan
    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan'); // Ubah ke 'id_pertanyaan'
    }

    public function responden(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user'); // Ubah ke 'id_user'
    }

    // public function pilihanJawaban(): BelongsTo
    // {
    //     return $this->belongsTo(PilihanJawaban::class, 'pilihan_jawaban_id');
    // }
}
