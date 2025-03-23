<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';
    protected $fillable = ['pertanyaan', 'jenis_pertanyaan'];

    public static $jenisPertanyaan = [
        'pekerjaan',
        'lingkungan_kerja',
        'kepemimpinan',
        'perusahaan',
    ];

    public function setJenisPertanyaanAttribute($value)
    {
        if (!in_array($value, self::$jenisPertanyaan)) {
            throw new \Exception('Jenis pertanyaan tidak valid');
        }

        $this->attributes['jenis_pertanyaan'] = $value;
    }

    public function pilihanJawabans(): HasMany
    {
        // return $this->hasMany(PilihanJawaban::class);
        return $this->hasMany(PilihanJawaban::class, 'id_pertanyaan');
    }

    public function jawabanRespondens(): HasMany
    {
        return $this->hasMany(JawabanResponden::class);
    }
}
