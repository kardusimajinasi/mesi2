<?php

namespace App\Http\Controllers\Level;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use Yajra\DataTables\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        return view('level.data-level');
    }

    public function getDataLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = Level::select(['id', 'level']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row) {
                    $editBtn = '<button class="btn btn-warning btn-sm" data-id="'.$row->id.'" data-nama="'.$row->level.'" onclick="editLevel(this)">Edit</button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm" data-id="'.$row->id.'" onclick="deleteLevel(this)">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function simpanDatalevel(Request $request)
    {
        $request->validate([
            'level' => 'required|string|max:255',
        ]);

        try {
            level::create([
                'level' => $request->level,
            ]);
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data!'], 500);
        }
    }

    public function editDatalevel($id)
    {
        $level = level::find($id);
        if ($level) {
            return response()->json($level);
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

    public function updateDatalevel(Request $request, $id)
    {
        $request->validate([
            'level' => 'required|string|max:255',
        ]);

        $level = level::find($id);

        if ($level) {
            try {
                $level->update([
                    'level' => $request->level,
                ]);
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data!'], 500);
            }
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

    public function hapusDataLevel($id)
    {
        $level = level::find($id);

        if ($level) {
            try {
                $level->delete();
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data!'], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }
}
