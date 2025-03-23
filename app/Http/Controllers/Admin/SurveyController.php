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
        $jenisPertanyaan = $request->input('jenis_pertanyaan');
        $pertanyaans = Pertanyaan::with('pilihanJawabans')
            ->when($jenisPertanyaan !== 'all', function ($query) use ($jenisPertanyaan) {
                $query->where('jenis_pertanyaan', $jenisPertanyaan);
            })
            ->get();

        // Buat kolom action untuk edit dan hapus
        $actionColumn = function ($pertanyaan) {
            $editLink = route('admin.survey.editData', $pertanyaan->id);
            $deleteLink = route('admin.survey.hapusData', $pertanyaan->id);

            return "
            <a href='{$editLink}'>Edit</a> |
            <a href='{$deleteLink}'>Hapus</a>
        ";
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
        // Kode untuk mengambil data jawaban
        return true;
    }

    public function getDataSurvey(Request $request)
    {
        // Kode untuk mengambil data survey
        return 'tester tester';
    }

    public function create()
    {
        return view('admin.survey.create');
    }

    public function store(Request $request)
    {
        $pertanyaan = new Pertanyaan();
        $pertanyaan->pertanyaan = $request->input('pertanyaan');
        $pertanyaan->save();
        return redirect()->route('admin.survey.index')->with('success', 'Pertanyaan berhasil ditambahkan!');
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
