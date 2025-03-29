<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\PilihanJawaban;
use App\Models\KategoriJawaban;
use App\Models\SkalaJawaban;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $kategoriJawaban = KategoriJawaban::all(); // Ambil semua data kategori jawaban
        $skalaJawaban = SkalaJawaban::all(); // Ambil semua data kategori jawaban
        return view('admin.survey.index', compact('kategoriJawaban', 'skalaJawaban'));
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

    public function create()
    {
        return view('admin.survey.partials.add');
    }


    public function store(Request $request)
    {
        // Validasi
        $validatedData = $request->validate([
            'pertanyaan' => [
                'required',
                'string',
                'regex:/^[A-Za-z\s.,!?]+$/',
                'max:255'
            ],
        ], [
            'pertanyaan.regex' => 'Pertanyaan hanya boleh mengandung huruf, spasi, dan tanda baca yang diizinkan (.,!?).',
        ]);

        try {
            // Create a new Pertanyaan instance and set its properties
            $pertanyaan = new Pertanyaan();
            $pertanyaan->pertanyaan = $validatedData['pertanyaan'];
            // $pertanyaan->jenis_pertanyaan = $validatedData['jenis_pertanyaan'];

            // Save the new question to the database
            $pertanyaan->save();

            // Redirect back with a success message (Flash message)
            return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Return an error message if something goes wrong
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $pertanyaan = Pertanyaan::find($id);

        if (!$pertanyaan) {
            return response()->json(['error' => 'Pertanyaan tidak ditemukan'], 404);
        }

        return response()->json($pertanyaan);
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

        $datatable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        return $datatable;
    }

    // public function getDataSurvey(Request $request)
    // {
    //     $data = Pertanyaan::select(
    //         'pertanyaan.id', // Include the ID for proper grouping
    //         'pertanyaan.pertanyaan',
    //         'pertanyaan.jenis_pertanyaan',
    //         DB::raw('GROUP_CONCAT(pilihan_jawaban.pilihan SEPARATOR ", ") AS pilihan_jawaban'),
    //         DB::raw('GROUP_CONCAT(pilihan_jawaban.nilai SEPARATOR ", ") AS nilai_jawaban')
    //     )
    //         ->leftJoin('pilihan_jawaban', 'pilihan_jawaban.id_pertanyaan', '=', 'pertanyaan.id')
    //         ->whereNotNull('pilihan_jawaban.pilihan') // Ensure only non-null pilihan
    //         ->groupBy('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.jenis_pertanyaan')
    //         ->orderBy('pertanyaan.pertanyaan')
    //         ->get();

    //     return DataTables::of($data)
    //         ->addIndexColumn() // Add index column for DataTables
    //         ->make(true); // Return DataTables response
    // }

    public function getDataSurvey(Request $request)
    {
        $pertanyaans = Pertanyaan::select(
            'pertanyaan.id AS id_pertanyaan',
            'pertanyaan.pertanyaan AS pertanyaan',
            DB::raw('GROUP_CONCAT(DISTINCT skala_jawaban.nama_skala) AS skala_jawaban'),
            'kategori_jawaban.id AS id_kategori_jawaban',
            'kategori_jawaban.nama_kategori AS kategori_jawaban'
        )
            ->join('pilihan_jawaban', 'pertanyaan.id', '=', 'pilihan_jawaban.id_pertanyaan')
            ->join('skala_jawaban', 'pilihan_jawaban.id_skala_jawaban', '=', 'skala_jawaban.id')
            ->join('kategori_jawaban', 'skala_jawaban.id_kategori_jawaban', '=', 'kategori_jawaban.id')
            ->groupBy('pertanyaan.id', 'pertanyaan.pertanyaan', 'kategori_jawaban.id', 'kategori_jawaban.nama_kategori')
            ->get();

        return DataTables::of($pertanyaans)
            ->addIndexColumn() // Add index column for DataTables
            ->make(true); // Return DataTables response
    }
}
