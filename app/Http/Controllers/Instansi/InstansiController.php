<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instansi;
use Yajra\DataTables\DataTables;

class InstansiController extends Controller
{
    public function index()
    {
        return view('instansi.data-instansi');
    }

    public function instansiCari(Request $request)
    {
        $cari = $request->get('q');
        $instansi = Instansi::where('instansi', 'LIKE', "%{$cari}%")->get(['id', 'instansi']);

        $formattedInstansi = $instansi->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->instansi
            ];
        });

        return response()->json($formattedInstansi);
    }

    public function getDataInstansi(Request $request)
    {
        if ($request->ajax()) {
            $data = Instansi::select(['id', 'instansi']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row) {
                    $editBtn = '<button class="btn btn-warning btn-sm" data-id="'.$row->id.'" data-nama="'.$row->instansi.'" onclick="editInstansi(this)">Edit</button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm" data-id="'.$row->id.'" onclick="deleteInstansi(this)">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function simpanDataInstansi(Request $request)
    {
        $request->validate([
            'instansi' => 'required|string|max:255',
        ]);

        try {
            Instansi::create([
                'instansi' => strtoupper($request->instansi),
            ]);
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data!'], 500);
        }
    }

    public function editDataInstansi($id)
    {
        $instansi = Instansi::find($id);
        if ($instansi) {
            return response()->json($instansi);
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

    public function updateDataInstansi(Request $request, $id)
    {
        $request->validate([
            'instansi' => 'required|string|max:255',
        ]);

        $instansi = Instansi::find($id);

        if ($instansi) {
            try {
                $instansi->update([
                    'instansi' => strtoupper($request->instansi),
                ]);
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data!'], 500);
            }
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

    public function hapusDataInstansi($id)
    {
        $instansi = Instansi::find($id);

        if ($instansi) {
            try {
                $instansi->delete();
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data!'], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

}

