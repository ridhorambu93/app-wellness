<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\PilihanJawaban;
use App\Models\KategoriJawaban;
use App\Models\SkalaJawaban;
use App\Models\Survey;
use App\Models\JawabanResponden;
use App\Models\Responden;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function index()
    {
        $kategori_jawaban = KategoriJawaban::all();
        $skala_jawaban = SkalaJawaban::with('kategoriJawaban')->get()->groupBy('id_kategori_jawaban');
        // dd($kategori_jawaban);
        return view('admin.survey.index', compact('kategori_jawaban', 'skala_jawaban'));
    }

    public function getDataSurvey(Request $request)
    {
        $surveys = Survey::select('id', 'nama_survey', 'deskripsi_survey', 'tanggal_mulai', 'tanggal_akhir', 'status_survey')->get();
        return DataTables::of($surveys)
            ->addIndexColumn() // Add index column for DataTables
            ->make(true); // Return DataTables response

        // $surveys = Survey::with(['pertanyaan' => function ($query) {
        //     $query->with(['kategoriJawaban.skalaJawaban']); // Eager load relasi skala jawaban
        // }])->get();

        // $data = $surveys->map(function ($survey) {
        //     $pertanyaanData = $survey->pertanyaan->map(function ($pertanyaan) {
        //         $jawaban = '';
        //         if ($pertanyaan->tipe_jawaban === 'skala') {
        //             // Ambil skala jawaban
        //             $jawaban_dan_nilai = DB::select(DB::raw("
        //                 SELECT COALESCE(GROUP_CONCAT(CONCAT(sj.nama_skala, ' (', sj.nilai, ')') SEPARATOR ', '), 'Tidak ada skala jawaban') AS jawaban_dan_nilai
        //                 FROM skala_jawaban sj
        //                 WHERE sj.id_kategori_jawaban = :kategori_jawaban_id
        //             "), ['kategori_jawaban_id' => $pertanyaan->id_kategori_jawaban])[0]->jawaban_dan_nilai;

        //             $jawaban = $jawaban_dan_nilai;
        //         } else {
        //             $jawaban = 'Bukan pertanyaan skala'; // Atau pesan lain yang sesuai
        //         }

        //         return [
        //             'pertanyaan' => $pertanyaan->pertanyaan,
        //             'tipe_jawaban' => $pertanyaan->tipe_jawaban,
        //             'jawaban' => $jawaban,
        //         ];
        //     });

        //     return [
        //         'id' => $survey->id,
        //         'nama_survey' => $survey->nama_survey,
        //         'deskripsi_survey' => $survey->deskripsi_survey,
        //         'tanggal_mulai' => $survey->tanggal_mulai,
        //         'tanggal_akhir' => $survey->tanggal_akhir,
        //         'status_survey' => $survey->status_survey,
        //         'pertanyaan' => $pertanyaanData, // Data pertanyaan yang sudah diformat
        //     ];
        // });

        // return DataTables::of($data)
        //     ->addIndexColumn()
        //     ->make(true);
    }

    public function getSurveyWithQuestions($id)
    {
        // Mengambil data survey beserta pertanyaan yang terkait
        $survey = Survey::with('pertanyaan')->find($id);

        // Cek jika survey tidak ditemukan
        if (!$survey) {
            return response()->json(['error' => 'Survey not found'], 404);
        }

        // Mengembalikan data survey beserta pertanyaan sebagai JSON
        return response()->json($survey);
    }

    public function addQuestion(Request $request, $surveyId)
    {
        // Validasi input
        $validatedData = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'type' => 'required|string',
            'id_kategori_jawaban' => 'required',
        ]);

        // Menambahkan pertanyaan baru ke survey
        $pertanyaan = new Pertanyaan();
        $pertanyaan->survey_id = $surveyId;
        $pertanyaan->pertanyaan = $validatedData['pertanyaan'];
        $pertanyaan->type = $validatedData['type'];
        $pertanyaan->id_kategori_jawaban = $validatedData['id_kategori_jawaban'];
        $pertanyaan->save();

        return response()->json(['success' => 'Pertanyaan berhasil ditambahkan!']);
    }

    public function store(Request $request)
    {
        // Cudstom Validasi
        $validatedData = $request->validate([
            'nama_survey' => [
                'required',
                'string',
                'regex:/^[A-Za-z\s.,!?]+$/',
                'max:255'
            ],
            'deskripsi_survey' => [
                'required',
                'string',
                'regex:/^[A-Za-z\s.,!?]+$/'
            ],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date', 'after:tanggal_mulai']
        ], [
            'nama_survey.required' => 'Nama survey wajib diisi.',
            'nama_survey.string' => 'Nama survey harus berupa string.',
            'nama_survey.regex' => 'Nama survey hanya boleh berisi huruf, spasi, dan simbol .,!?.',
            'nama_survey.max' => 'Nama survey maksimal 255 karakter.',
            'deskripsi_survey.required' => 'Deskripsi survey wajib diisi.',
            'deskripsi_survey.string' => 'Deskripsi survey harus berupa string.',
            'deskripsi_survey.regex' => 'Deskripsi survey hanya boleh berisi huruf, spasi, dan simbol .,!?.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Tanggal mulai harus berupa tanggal.',
            'tanggal_akhir.required' => 'Tanggal akhir wajib diisi.',
            'tanggal_akhir.date' => 'Tanggal akhir harus berupa tanggal.',
            'tanggal_akhir.after' => 'Tanggal akhir harus setelah tanggal mulai.',
            'id_kategori_jawaban' => 'required|exists:kategori_jawaban,id',
        ]);

        $validatedData['status_survey'] = strtolower(trim($request->status_survey)) === 'nonaktif' ? 'nonaktif' : 'aktif';
        $validatedData['id_kategori_jawaban'] = $request->id_kategori_jawaban;
        
        try {
            Survey::create($validatedData);
            return redirect()->back()->with('success', 'Data Survey berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi
        $validatedData = $request->validate([
            'pertanyaan' => [
                'required',
                'string',
                'regex:/^[A-Za-z\s.,!?]+$/',
                'max:255'
            ],
            'jenis_pertanyaan' => 'required|string',
        ], [
            'pertanyaan.regex' => 'Pertanyaan hanya boleh mengandung huruf, spasi, dan tanda baca yang diizinkan (.,!?).',
        ]);

        try {
            // Find existing question and update
            $pertanyaan = Pertanyaan::findOrFail($id);
            $pertanyaan->pertanyaan = $validatedData['pertanyaan'];
            $pertanyaan->jenis_pertanyaan = $validatedData['jenis_pertanyaan'];
            $pertanyaan->save();

            return redirect()->back()->with('success', 'Pertanyaan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        // Find the 'Pertanyaan' record by ID
        $pertanyaan = Pertanyaan::find($id);

        // Check if the record exists
        if (!$pertanyaan) {
            // If the record does not exist, return an error response
            return response()->json(['error' => 'Data Pertanyaan tidak ditemukan!'], 404);
        }

        // Delete the 'Pertanyaan' record
        $pertanyaan->delete();

        // Return a success response as JSON
        return response()->json(['success' => 'Data Pertanyaan berhasil dihapus!']);
    }

    public function getData(Request $request)
    {
        $pertanyaans = Pertanyaan::with('pilihanJawabans')->get();

        // Buat kolom action untuk edit dan hapus
        $actionColumn = function ($pertanyaan) {
            $editLink = route('survey.edit', $pertanyaan->id);
            $deleteLink = route('survey.hapus-pertanyaan', $pertanyaan->id);
            return " <a href='{$editLink}'>Edit</a> | <a href='{$deleteLink}'>Hapus</a> ";
        };

        // Buat datatable
        $datatable = DataTables::of($pertanyaans)
            ->addIndexColumn()
            ->addColumn('action', $actionColumn)
            ->rawColumns(['action'])
            ->make(true);

        return $datatable;
    }

    public function getDataJawaban(Request $request)
    {
        $jawabans = PilihanJawaban::all();

        $data = [];
        foreach ($jawabans as $jawaban) {
            $data[] = [
                'id' => $jawaban->id,
                'jawaban' => $jawaban->pilihan,
                'nilai_jawaban' => $jawaban->nilai,
            ];
        }
        // Buat datatable
        $datatable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        return $datatable;
    }

    public function generalUserSurvey()
    {
        $surveys = Survey::get();
        return view('general.survey.index', compact('surveys'));
    }

    public function generalSurveyFill($id)
    {
        $surveys = Survey::with('pertanyaan.skalaJawaban')->find($id);
        // dd($survey);
        return view('general.survey.general-fill', compact('surveys'));
    }

    // public function submitSurvey(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'id_user' => 'required|exists:users,id',
    //         'id_pertanyaan' => 'required|array',
    //         'jawaban' => 'required|array',
    //         'jawaban.*' => 'string',
    //     ]);

    //     // Ambil id_user dari request
    //     $id_user = $request->input('id_user');

    //     // Debug: Cek nilai id_user
    //     Log::info('ID User:', ['id_user' => $id_user]);

    //     if (!$id_user) {
    //         return response()->json(['message' => 'ID pengguna tidak ditemukan.'], 400);
    //     }

    //     // Lanjutkan menyimpan jawaban
    // }


    public function submitSurvey(Request $request)
    {
        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Ambil data pengguna yang terautentikasi
        $user = auth()->user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_pertanyaan' => 'required|array',
            'id_pertanyaan.*' => 'exists:pertanyaan,id',
            'jawaban' => 'required|array',
            'jawaban.*' => 'string',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Insert atau ambil data responden
        $responden = Responden::firstOrCreate(
            ['email' => $user->email],
            ['nama' => $user->name]
        );

        // Proses setiap pertanyaan dan jawaban
        foreach ($request->id_pertanyaan as $index => $idPertanyaan) {
            // Mengonversi jawaban menjadi JSON
            $jawabanJson = json_encode($request->jawaban[$index]);
            $jawabanResponden = JawabanResponden::create([
                'id_user' => $user->id,
                'id_pertanyaan' => $idPertanyaan,
                'jawaban' => $jawabanJson,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update field id_jawaban_responden di tabel responden
            $responden->update(['id_jawaban_responden' => $jawabanResponden->id]);
        }

        return response()->json(['message' => 'Survey submitted successfully!', 'redirect' => route('menu-survey')]);
    }
}
