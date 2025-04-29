<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\PilihanJawaban;
use App\Models\KategoriJawaban;
use App\Models\SkalaJawaban;
use App\Models\Survey;
use App\Models\JawabanResponden;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $kategori_jawaban = KategoriJawaban::all();
        $skala_jawaban = SkalaJawaban::with('kategoriJawaban')->get()->groupBy('id_kategori_jawaban');
        return view('admin.survey.index', compact('kategori_jawaban', 'skala_jawaban'));
    }

    public function getDataSurvey(Request $request)
    {
        // $pertanyaans = Pertanyaan::select(
        //     'pertanyaan.id AS id_pertanyaan',
        //     'pertanyaan.pertanyaan AS pertanyaan',
        //     DB::raw('GROUP_CONCAT(DISTINCT skala_jawaban.nama_skala) AS skala_jawaban'),
        //     'kategori_jawaban.id AS id_kategori_jawaban',
        //     'kategori_jawaban.nama_kategori AS kategori_jawaban'
        // )
        //     ->join('pilihan_jawaban', 'pertanyaan.id', '=', 'pilihan_jawaban.id_pertanyaan')
        //     ->join('skala_jawaban', 'pilihan_jawaban.id_skala_jawaban', '=', 'skala_jawaban.id')
        //     ->join('kategori_jawaban', 'skala_jawaban.id_kategori_jawaban', '=', 'kategori_jawaban.id')
        //     ->groupBy('pertanyaan.id', 'pertanyaan.pertanyaan', 'kategori_jawaban.id', 'kategori_jawaban.nama_kategori')
        //     ->get();

        // return DataTables::of($pertanyaans)
        //     ->addIndexColumn() // Add index column for DataTables
        //     ->make(true); // Return DataTables response

        $surveys = Survey::select('id', 'nama_survey', 'deskripsi_survey', 'tanggal_mulai', 'tanggal_akhir', 'status_survey')->get();
        return DataTables::of($surveys)
            ->addIndexColumn() // Add index column for DataTables
            ->make(true); // Return DataTables response
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
            'tanggal_akhir.after' => 'Tanggal akhir harus setelah tanggal mulai.'
        ]);

        $validatedData['status_survey'] = strtolower(trim($request->status_survey)) === 'nonaktif' ? 'nonaktif' : 'aktif';
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
        $surveys = Survey::find($id);
        $pertanyaans = Pertanyaan::with('skalaJawaban')->get();
        foreach ($pertanyaans as $data_pertanyaan) {
            echo $data_pertanyaan->isi_pertanyaan;

            foreach ($data_pertanyaan->skalaJawaban as $jawaban) {
                echo $jawaban->opsi_jawaban;
            }
        }

        return view('general.survey.general-fill', compact('surveys', 'pertanyaans'));
    }

    public function submitSurvey(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_responden' => 'required|exists:users,id', // Pastikan id_responden ada di tabel users
            'id_pertanyaan' => 'required|array',
            'jawaban' => 'required|array',
            'jawaban.*' => 'string', // Atau sesuai tipe data jawaban yang diharapkan
        ]);

        // Ambil data dari request
        $id_responden = $request->input('id_responden');
        $id_pertanyaans = $request->input('id_pertanyaan');
        $jawabans = $request->input('jawaban');

        // Memastikan jumlah pertanyaan dan jawaban cocok
        if (count($id_pertanyaans) !== count($jawabans)) {
            return response()->json(['message' => 'Jumlah pertanyaan dan jawaban tidak cocok.'], 400);
        }

        // Simpan setiap jawaban ke dalam database
        foreach ($id_pertanyaans as $index => $id_pertanyaan) {
            JawabanResponden::create([
                'id_user' => $id_responden, // Gunakan id_responden sebagai id_user
                'id_pertanyaan' => $id_pertanyaan,
                'jawaban' => $jawabans[$index],
            ]);
        }

        return response()->json(['message' => 'Data berhasil diterima!'], 201);
    }
}
