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
                'id_skala_jawaban' => 1, // ID skala jawaban untuk pertanyaan pertama
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[0],
                'id_skala_jawaban' => 2,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[0],
                'id_skala_jawaban' => 3,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[0],
                'id_skala_jawaban' => 4,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[0],
                'id_skala_jawaban' => 5,
            ],
            // Pilihan untuk pertanyaan kedua
            [
                'id_pertanyaan' => $pertanyaanIds[1],
                'id_skala_jawaban' => 6,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[1],
                'id_skala_jawaban' => 7,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[1],
                'id_skala_jawaban' => 8,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[1],
                'id_skala_jawaban' => 9,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[1],
                'id_skala_jawaban' => 10,
            ],
            // Tambahkan pilihan untuk pertanyaan lainnya sesuai kebutuhan
            [
                'id_pertanyaan' => $pertanyaanIds[2],
                'id_skala_jawaban' => 11,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[2],
                'id_skala_jawaban' => 12,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[2],
                'id_skala_jawaban' => 13,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[2],
                'id_skala_jawaban' => 14,
            ],
            [
                'id_pertanyaan' => $pertanyaanIds[2],
                'id_skala_jawaban' => 15,
            ],
        ];

        // Menyimpan pilihan jawaban ke dalam database
        foreach ($pilihanJawabans as $jawaban) {
            PilihanJawaban::create($jawaban);
        }
    }
}
