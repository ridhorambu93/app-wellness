<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pertanyaan;

class SurveyPertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pertanyaans = [
            [
                'pertanyaan' => 'Seberapa puas Anda dengan lingkungan kerja di perusahaan?',
                'survey_id' => 3, // Ganti dengan ID survey yang sesuai
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 1
            ],
            [
                'pertanyaan' => 'Seberapa sering Anda merasa nyaman berkomunikasi dengan rekan kerja?',
                'survey_id' => 3,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 1
            ],
            [
                'pertanyaan' => 'Bagaimana Anda menilai fasilitas yang tersedia di lingkungan kerja?',
                'survey_id' => 3,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 1
            ],
            [
                'pertanyaan' => 'Seberapa baik dukungan yang Anda terima dari manajemen?',
                'survey_id' => 3,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 1
            ],
            [
                'pertanyaan' => 'Apa yang menurut Anda perlu diperbaiki dalam lingkungan kerja?',
                'survey_id' => 3,
                'type' => 'essai', // Pertanyaan essai
            ],
        ];

        foreach ($pertanyaans as $pertanyaan) {
            Pertanyaan::create($pertanyaan);
        }
    }
}
