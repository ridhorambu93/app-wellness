<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriJawaban;


class KategoriJawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriJawaban = [
            [
                'nama_kategori' => 'Skala Kepuasan',
            ],
            [
                'nama_kategori' => 'Skala Likert',
            ],
            [
                'nama_kategori' => 'Skala Tingkat Kepuasan',
            ],
        ];

        foreach ($kategoriJawaban as $item) {
            KategoriJawaban::create($item);
        }
    }
}
