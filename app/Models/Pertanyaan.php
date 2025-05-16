<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';
    protected $fillable = ['pertanyaan', 'survey_id', 'type', 'id_kategori_jawaban'];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function jawaban(): HasMany
    {
        return $this->hasMany(JawabanResponden::class, 'pertanyaan_id');
    }

    public function pilihanJawabans(): HasMany
    {
        return $this->hasMany(PilihanJawaban::class, 'id_pertanyaan');
    }

    public function skalaJawaban()
    {
        return $this->hasMany(SkalaJawaban::class, 'id_kategori_jawaban', 'id_kategori_jawaban');
    }

    public function kategoriJawaban()
    {
        return $this->belongsTo(KategoriJawaban::class, 'id_kategori_jawaban', 'id');
    }
}
