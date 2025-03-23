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
                'jenis_pertanyaan' => 'lingkungan_kerja',
            ],
            [
                'pertanyaan' => 'Bagaimana Anda menilai kesempatan untuk berkembang dan meningkatkan karir di perusahaan?',
                'jenis_pertanyaan' => 'kepemimpinan',
            ],
            [
                'pertanyaan' => 'Seberapa puas Anda dengan kompensasi dan benefit yang diberikan oleh perusahaan?',
                'jenis_pertanyaan' => 'perusahaan',
            ],
            [
                'pertanyaan' => 'Seberapa puas Anda dengan komunikasi antara atasan dan bawahan di perusahaan?',
                'jenis_pertanyaan' => 'lingkungan_kerja',
            ],
            [
                'pertanyaan' => 'Bagaimana Anda menilai kemampuan perusahaan dalam mengembangkan karyawan?',
                'jenis_pertanyaan' => 'kepemimpinan',
            ],
            [
                'pertanyaan' => 'Seberapa puas Anda dengan kebijakan dan prosedur yang berlaku di perusahaan?',
                'jenis_pertanyaan' => 'perusahaan',
            ],
        ];

        foreach ($pertanyaans as $pertanyaan) {
            Pertanyaan::create($pertanyaan);
        }
    }
}
