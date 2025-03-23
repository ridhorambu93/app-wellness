<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PilihanJawaban extends Model
{
    use HasFactory;
    protected $table = 'pilihan_jawaban';
    protected $fillable = ['id_pertanyaan', 'pilihan', 'nilai'];

    public function pertanyaan()
    {
        // return $this->belongsTo(Pertanyaan::class);
        return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan');
    }

    public function jawabanRespondens()
    {
        return $this->hasMany(JawabanResponden::class);
    }
}
