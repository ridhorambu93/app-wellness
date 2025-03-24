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
            $editLink = route('admin.survey.editData', $pertanyaan->id);
            $deleteLink = route('admin.survey.hapusData', $pertanyaan->id);
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
        $jawabans = PilihanJawaban::with('pertanyaan')->get(); // Ambil semua pilihan jawaban beserta pertanyaannya

        $data = [];
        foreach ($jawabans as $jawaban) {
            $data[] = [
                'id' => $jawaban->id,
                'pertanyaan' => $jawaban->pertanyaan->pertanyaan, // Menampilkan pertanyaan yang terkait
                'jawaban' => $jawaban->pilihan, // Menampilkan pilihan jawaban
            ];
        }

        // Buat datatable
        $datatable = DataTables::of($data)
            ->addIndexColumn() // Menambahkan kolom nomor urut
            ->make(true); // Tidak menggunakan rawColumns karena tidak ada HTML

        return $datatable;
    }

    public function getDataSurvey(Request $request)
    {
        // Kode untuk mengambil data survey
        return 'tester tester';
    }

    public function create()
    {
        return view('admin.survey.partials.add');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jenis_pertanyaan' => 'required|string',
        ]);

        try {
            // Create a new Pertanyaan instance and set its properties
            $pertanyaan = new Pertanyaan();
            $pertanyaan->pertanyaan = $validatedData['pertanyaan'];
            $pertanyaan->jenis_pertanyaan = $validatedData['jenis_pertanyaan'];

            // Save the new question to the database
            $pertanyaan->save();

            // Redirect to the survey index route with a success message
            return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan!');
            // return redirect()->route('adminSurveyShow')->with('success', 'Pertanyaan berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Handle the exception and redirect back with an error message
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $pertanyaan = Pertanyaan::find($id);
        return view('admin.survey.partials.edit', compact('pertanyaan'));
    }

    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::find($id);
        $pertanyaan->pertanyaan = $request->input('pertanyaan');
        $pertanyaan->save();
        return redirect()->route('admin.survey.index')->with('success', 'Pertanyaan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::find($id);
        $pertanyaan->delete();
        return redirect()->route('admin.survey.index')->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
