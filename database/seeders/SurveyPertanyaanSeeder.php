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

            // Kehadiran dan Ketepatan Waktu
            [
                'pertanyaan' => 'Saya selalu hadir tepat waktu sesuai dengan jadwal kerja yang ditetapkan. (1-5)',
                'survey_id' => 2, // Ganti dengan ID survey yang sesuai
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 2, // Sesuaikan dengan kategori jawaban skala likert Anda
            ],
            [
                'pertanyaan' => 'Saya jarang terlambat masuk kerja atau meninggalkan pekerjaan lebih awal. (1-5)',
                'survey_id' => 2,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 2,
            ],

            // Penyelesaian Tugas
            [
                'pertanyaan' => 'Saya selalu menyelesaikan tugas yang diberikan sesuai dengan tenggat waktu yang ditetapkan. (1-5)',
                'survey_id' => 2,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 2,
            ],
            [
                'pertanyaan' => 'Saya memastikan semua tugas diselesaikan dengan kualitas yang baik. (1-5)',
                'survey_id' => 2,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 2,
            ],
            [
                'pertanyaan' => 'Saya proaktif dalam mencari solusi jika menghadapi kendala dalam menyelesaikan tugas. (1-5)',
                'survey_id' => 2,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 2,
            ],

            // Kepatuhan Terhadap Aturan dan Prosedur
            [
                'pertanyaan' => 'Saya selalu mematuhi semua aturan dan prosedur perusahaan yang berlaku. (1-5)',
                'survey_id' => 2,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 2,
            ],
            [
                'pertanyaan' => 'Saya memahami dan mengikuti kebijakan perusahaan terkait kedisiplinan. (1-5)',
                'survey_id' => 2,
                'type' => 'pilihan ganda',
                'id_kategori_jawaban' => 2,
            ],

            // Pertanyaan Terbuka
            [
                'pertanyaan' => 'Area apa yang menurut Anda perlu diperbaiki dalam hal kedisiplinan di lingkungan kerja kita?',
                'survey_id' => 2,
                'type' => 'essai', // Pertanyaan essai
            ],
        ];

        foreach ($pertanyaans as $pertanyaan) {
            Pertanyaan::create($pertanyaan);
        }
    }
}
