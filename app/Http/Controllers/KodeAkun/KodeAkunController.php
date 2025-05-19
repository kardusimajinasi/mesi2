<?php

namespace App\Http\Controllers\KodeAkun;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\KodeAkun;

class KodeAkunController extends Controller
{
    public function index()
    {
        return view('kodeakun.data-kodeakun');
    }


    public function getDataKodeAkun(Request $request)
    {
        if ($request->ajax()) {
            $data = KodeAkun::select(['id', 'nama_akun']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row) {
                    $editBtn = '<button class="btn btn-warning btn-sm" data-id="'.$row->id.'" data-nama="'.$row->nama_akun.'" onclick="editKodeAkun(this)">Edit</button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm" data-id="'.$row->id.'" onclick="deleteKodeAkun(this)">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function simpanDataKodeAkun(Request $request)
    {
        $request->validate([
            'nama_akun' => 'required|string|max:255',
        ]);

        try {
            KodeAkun::create([
                'nama_akun' => strtoupper($request->nama_akun),
            ]);
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data!'], 500);
        }
    }

    public function editDataKodeAkun($id)
    {
        $kodeAkun = KodeAkun::find($id);
        if ($kodeAkun) {
            return response()->json($kodeAkun); // Pastikan data yang dikembalikan adalah objek KodeAkun
        }
        
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

    public function updateDataKodeAKun(Request $request, $id)
    {
        $request->validate([
            'nama_akun' => 'required|string|max:255',
        ]);

        $nama_akun = KodeAkun::find($id);

        if ($nama_akun) {
            try {
                $nama_akun->update([
                    'nama_akun' => strtoupper($request->nama_akun),
                ]);
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data!'], 500);
            }
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }

    public function hapusDataKodeAkun($id)
    {
        $nama_akun = KodeAkun::find($id);

        if ($nama_akun) {
            try {
                $nama_akun->delete();
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data!'], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
    }
}
