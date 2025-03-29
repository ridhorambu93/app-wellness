<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'id_kategori_jawaban' => 1, // tambahkan id kategori jawaban
            ],
            [
                'pertanyaan' => 'Bagaimana Anda menilai kesempatan untuk berkembang dan meningkatkan karir di perusahaan?',
                'id_kategori_jawaban' => 2, // tambahkan id kategori jawaban
            ],
            [
                'pertanyaan' => 'Seberapa puas Anda dengan kompensasi dan benefit yang diberikan oleh perusahaan?',
                'id_kategori_jawaban' => 3, // tambahkan id kategori jawaban
            ],
            [
                'pertanyaan' => 'Seberapa puas Anda dengan komunikasi antara atasan dan bawahan di perusahaan?',
                'id_kategori_jawaban' => 1, // tambahkan id kategori jawaban
            ],
            [
                'pertanyaan' => 'Bagaimana Anda menilai kemampuan perusahaan dalam mengembangkan karyawan?',
                'id_kategori_jawaban' => 2, // tambahkan id kategori jawaban
            ],
            [
                'pertanyaan' => 'Seberapa puas Anda dengan kebijakan dan prosedur yang berlaku di perusahaan?',
                'id_kategori_jawaban' => 3, // tambahkan id kategori jawaban
            ],
        ];

        foreach ($pertanyaans as $pertanyaan) {
            Pertanyaan::create($pertanyaan);
        }
    }
}
