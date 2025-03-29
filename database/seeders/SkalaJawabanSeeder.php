<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SkalaJawaban;

class SkalaJawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $skalaJawaban = [
            [
                'id_kategori_jawaban' => 1,
                'nama_skala' => 'Sangat Puas',
                'nilai' => 5,
            ],
            [
                'id_kategori_jawaban' => 1,
                'nama_skala' => 'Puas',
                'nilai' => 4,
            ],
            [
                'id_kategori_jawaban' => 1,
                'nama_skala' => 'Netral',
                'nilai' => 3,
            ],
            [
                'id_kategori_jawaban' => 1,
                'nama_skala' => 'Tidak Puas',
                'nilai' => 2,
            ],
            [
                'id_kategori_jawaban' => 1,
                'nama_skala' => 'Sangat Tidak Puas',
                'nilai' => 1,
            ],
            [
                'id_kategori_jawaban' => 2,
                'nama_skala' => 'Sangat Setuju',
                'nilai' => 5,
            ],
            [
                'id_kategori_jawaban' => 2,
                'nama_skala' => 'Setuju',
                'nilai' => 4,
            ],
            [
                'id_kategori_jawaban' => 2,
                'nama_skala' => 'Netral',
                'nilai' => 3,
            ],
            [
                'id_kategori_jawaban' => 2,
                'nama_skala' => 'Tidak Setuju',
                'nilai' => 2,
            ],
            [
                'id_kategori_jawaban' => 2,
                'nama_skala' => 'Sangat Tidak Setuju',
                'nilai' => 1,
            ],
            [
                'id_kategori_jawaban' => 3,
                'nama_skala' => 'Sangat Tinggi',
                'nilai' => 5,
            ],
            [
                'id_kategori_jawaban' => 3,
                'nama_skala' => 'Tinggi',
                'nilai' => 4,
            ],
            [
                'id_kategori_jawaban' => 3,
                'nama_skala' => 'Sedang',
                'nilai' => 3,
            ],
            [
                'id_kategori_jawaban' => 3,
                'nama_skala' => 'Rendah',
                'nilai' => 2,
            ],
            [
                'id_kategori_jawaban' => 3,
                'nama_skala' => 'Sangat Rendah',
                'nilai' => 1,
            ],
        ];

        foreach ($skalaJawaban as $item) {
            SkalaJawaban::create($item);
        }
    }
}
