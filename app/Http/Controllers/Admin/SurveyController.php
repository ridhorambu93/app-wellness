<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\PilihanJawaban;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SurveyController extends Controller
{
    public function index()
    {
        return view('admin.survey.index');
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
        // Validate the incoming data
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
            // Create a new Pertanyaan instance and set its properties
            $pertanyaan = new Pertanyaan();
            $pertanyaan->pertanyaan = $validatedData['pertanyaan'];
            $pertanyaan->jenis_pertanyaan = $validatedData['jenis_pertanyaan'];

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
        return view('admin.survey.index', compact('pertanyaan'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jenis_pertanyaan' => 'required|string',
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

        // Buat datatable
        $datatable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        return $datatable;
    }

    public function getDataSurvey(Request $request)
    {
        // Kode untuk mengambil data survey
        return 'tester tester';
    }
}
