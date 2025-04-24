<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';
    protected $fillable = ['pertanyaan'];

    public function pilihanJawabans(): HasMany
    {
        // return $this->hasMany(PilihanJawaban::class);
        return $this->hasMany(PilihanJawaban::class, 'id_pertanyaan');
    }

    public function skalaJawaban()
    {
        return $this->hasMany(SkalaJawaban::class, 'id_kategori_jawaban', 'id_kategori_jawaban');
    }

    public function jawabanRespondens(): HasMany
    {
        return $this->hasMany(JawabanResponden::class);
    }
}
