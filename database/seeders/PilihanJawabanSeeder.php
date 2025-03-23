<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PilihanJawaban; // Pastikan model ini ada
use App\Models\Pertanyaan; // Mengimpor model Pertanyaan untuk mendapatkan ID

class PilihanJawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan ID pertanyaan dari database
        $pertanyaanIds = Pertanyaan::pluck('id')->toArray();

        // Definisikan pilihan jawaban untuk pertanyaan
        $pilihanJawabans = [
            [
                'id_pertanyaan' => $pertanyaanIds[0], // ID pertanyaan pertama
                'pilihan' => 'Sangat Puas',
                'nilai' => 5,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[0],
                'pilihan' => 'Puas',
                'nilai' => 4,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[0],
                'pilihan' => 'Cukup Puas',
                'nilai' => 3,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[0],
                'pilihan' => 'Tidak Puas',
                'nilai' => 2,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[0],
                'pilihan' => 'Sangat Tidak Puas',
                'nilai' => 1,
            ],
            // Pilihan untuk pertanyaan kedua
            [
                'id_pertanyaan' => $pertanyaanIds[1],
                'pilihan' => 'Sangat Setuju',
                'nilai' => 5,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[1],
                'pilihan' => 'Setuju',
                'nilai' => 4,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[1],
                'pilihan' => 'Tidak Setuju',
                'nilai' => 2,
            ],
            // Tambahkan pilihan untuk pertanyaan lainnya sesuai kebutuhan
            [
                'id_pertanyaan' => $pertanyaanIds[2],
                'pilihan' => 'Sangat Memuaskan',
                'nilai' => 5,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[2],
                'pilihan' => 'Memuaskan',
                'nilai' => 4,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[2],
                'pilihan' => 'Cukup Memuaskan',
                'nilai' => 3,
            ],
        ];

        // Menyimpan pilihan jawaban ke dalam database
        foreach ($pilihanJawabans as $jawaban) {
            PilihanJawaban::create($jawaban);
        }
    }
}
