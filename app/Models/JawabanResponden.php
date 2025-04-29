<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanResponden extends Model
{
    use HasFactory;

    protected $fillable = ['pertanyaan_id', 'responden_id', 'pilihan_jawaban_id'];
    protected $table = 'jawaban_responden';
    // Relasi dengan model Pertanyaan
    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }

    public function responden(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responden_id');
    }

    // public function pilihanJawaban(): BelongsTo
    // {
    //     return $this->belongsTo(PilihanJawaban::class, 'pilihan_jawaban_id');
    // }
}
