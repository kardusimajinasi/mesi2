<?php

namespace App\Http\Controllers\Baliho;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Baliho;

class BalihoController extends Controller
{
    public function index()
    {
        return view('baliho.data-baliho');
    }

    public function getDataBaliho(Request $request)
    {
        if ($request->ajax()) {
            $data = Baliho::select(['id', 'nama_baliho', 'lokasi_baliho', 'foto_baliho', 'ukuran_baliho', 'layout_baliho']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row) {
                    $editBtn = '<button class="btn btn-warning btn-sm" data-id="'.$row->id.'" data-nama="'.$row->nama_baliho.'" onclick="editBaliho(this)">Edit</button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm" data-id="'.$row->id.'" onclick="deleteBaliho(this)">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->addColumn('foto_baliho', function($row) {
                    $url = Storage::url($row->foto_baliho);
                    return '<img src="' . $url . '" width="100" alt="Foto Baliho">';
                })
                ->rawColumns(['foto_baliho','aksi'])
                ->make(true);
        }
    }

    public function simpanDataBaliho(Request $request)
    {
        $request->validate([
            'nama_baliho' => 'required|string|max:255|unique:tbl_baliho,nama_baliho',
            'lokasi_baliho' => 'required|string|max:255',
            'foto_baliho' => 'required|image|mimes:jpg,png|max:5120',
            'ukuran_baliho' => 'required|string|max:255',
            'layout_baliho' => 'required|string|max:255',
        ], [
            'foto_baliho.required' => 'Foto baliho harus diunggah.',
            'foto_baliho.image' => 'Foto baliho harus berupa gambar.',
            'foto_baliho.mimes' => 'Foto baliho harus berformat JPG atau PNG.',
            'foto_baliho.max' => 'Ukuran foto baliho tidak boleh lebih dari 2MB.',
        ]);

        try {
            $balihoData = [
                'nama_baliho' => $request->nama_baliho,
                'lokasi_baliho' => $request->lokasi_baliho,
                'ukuran_baliho' => $request->ukuran_baliho,
                'layout_baliho' => $request->layout_baliho,
            ];

            if ($request->hasFile('foto_baliho')) {
                $file = $request->file('foto_baliho');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('foto_baliho', $filename, 'public');
                $balihoData['foto_baliho'] = $filePath;
            }

            Baliho::create($balihoData);

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data!'], 500);
        }
    }

    public function editDataBaliho($id)
    {
        $baliho = Baliho::find($id);
        if (!$baliho) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['data' => $baliho]);
    }

    public function updateDataBaliho(Request $request, $id)
    {
        $baliho = Baliho::findOrFail($id);

        $validated = $request->validate([
            'nama_baliho' => 'required|string',
            'lokasi_baliho' => 'required|string',
            'ukuran_baliho' => 'required|string',
            'layout_baliho' => 'required|string',
            'foto_baliho' => 'nullable|image|max:2048|mimes:jpg,png',
        ]);

        if ($request->hasFile('foto_baliho')) {
            if ($baliho->foto_baliho) {
                Storage::delete('public/' . $baliho->foto_baliho);
            }

            $filename = time() . '.' . $request->file('foto_baliho')->getClientOriginalExtension();
            $path = $request->file('foto_baliho')->storeAs('public/foto_baliho', $filename);

            $baliho->foto_baliho = 'foto_baliho/' . $filename;
        }

        $baliho->nama_baliho = $validated['nama_baliho'];
        $baliho->lokasi_baliho = $validated['lokasi_baliho'];
        $baliho->ukuran_baliho = $validated['ukuran_baliho'];
        $baliho->layout_baliho = $validated['layout_baliho'];

        $baliho->save();

        return response()->json(['success' => true]);
    }


    public function hapusDataBaliho($id)
    {
        try {
            $baliho = Baliho::findOrFail($id);

            if (Storage::exists($baliho->foto_baliho)) {
                Storage::delete($baliho->foto_baliho);
            }

            $baliho->delete();

            return response()->json(['success' => true, 'message' => 'Data baliho berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
