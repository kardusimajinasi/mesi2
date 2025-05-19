<?php

namespace App\Http\Controllers\PesanMesi;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\DetailPesan;
use App\Models\PesanMesi;
use App\Models\Instansi;
use App\Models\Baliho;
use App\Models\Level;
use App\Models\User;
use Carbon\Carbon;

class PesanMesiController extends Controller
{
    public function index()
    {
        $level = Level::all();
        $baliho = Baliho::all();
        $instansi = Instansi::all();
        $kodeTransaksi = $this->generateKodeTransaksi();
        $pesanan = PesanMesi::where('user_id', Auth::id())->first();

        return view('pesanmesi.pesan', compact('baliho', 'instansi', 'level', 'kodeTransaksi', 'pesanan'));
    }

    private function generateKodeTransaksi()
    {
        $timestamp = now()->format('YmdHi');
        $randomCode = Str::random(4);
        return $timestamp . $randomCode;
    }

    public function rekapbaliho(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_detail_trans_pesan as dtp')
                ->join('tbl_pesan as p', 'dtp.kode_trans_fk', '=', 'p.kode_trans')
                ->join('tbl_baliho as b', 'dtp.baliho_id', '=', 'b.id')
                ->join('tbl_instansi as i', 'p.instansi_id', '=', 'i.id')
                ->select(
                    DB::raw('ANY_VALUE(p.id) as id'),
                    'p.kode_trans',
                    DB::raw('GROUP_CONCAT(DISTINCT b.nama_baliho) as baliho_ids'),
                    DB::raw('MAX(i.instansi) as instansi'),
                    DB::raw('MAX(p.nama_pic) as nama_pic'),
                    DB::raw('MAX(p.tlp_pic) as tlp_pic'),
                    DB::raw('MAX(p.keterangan_event) as keterangan_event'),
                    DB::raw('MAX(p.tanggal_mulai) as tanggal_mulai'),
                    DB::raw('MAX(p.tanggal_selesai) as tanggal_selesai'),
                    DB::raw('MAX(p.no_surat) as no_surat'),
                    DB::raw('MAX(p.perihal_surat) as perihal_surat'),
                    DB::raw('MAX(p.tgl_surat) as tgl_surat')
                )
                ->groupBy('p.kode_trans')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $uploadLepasBtn = '<button class="btn btn-secondary btn-sm uploadLepas-btn" data-id="{{ $row->id }}">Upload Foto Lepas Baliho</button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm hapus-btn" data-id="{{ $row->id }}">Hapus</button>';
                    $detailBtn = '<button class="btn btn-info btn-sm"
                                    data-id="' . $row->id . '"
                                    data-tglmulai="' . $row->tanggal_mulai . '"
                                    data-tglselesai="' . $row->tanggal_selesai . '"
                                    data-nosurat="' . $row->no_surat . '"
                                    data-perihal="' . $row->perihal_surat . '"
                                    data-tglsurat="' . $row->tgl_surat . '"
                                    onclick="detailRekap(this)">Detail</button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm hapus-btn" data-id="{{ $row->id }}">Hapus</button>';
                    return $deleteBtn . ' ' . $detailBtn . ' ' . $uploadLepasBtn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function hapusOrderBaliho($id)
    {
        try {
            DB::beginTransaction();
            DB::table('tbl_detail_trans_pesan')->where('kode_trans_fk', function ($query) use ($id) {
                $query->select('kode_trans')->from('tbl_pesan')->where('id', $id);
            })->delete();

            DB::table('tbl_pesan')->where('id', $id)->delete();

            DB::commit();

            return response()->json(['success' => 'Data berhasil dihapus!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }


    public function cekTanggal(Request $request)
    {
        $request->validate([
            'baliho_ids' => 'required|array|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        $balihoIds = $request->baliho_ids;
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $result = $this->cekTanggalLogic($balihoIds, $tanggalMulai, $tanggalSelesai);
        Log::info('Response untuk cekTanggal:', $result);

        return response()->json($result);
    }

    private function cekTanggalLogic($balihoIds, $tanggalMulai, $tanggalSelesai)
    {
        $tanggalMulai = Carbon::parse($tanggalMulai)->format('Y-m-d');
        $tanggalSelesai = Carbon::parse($tanggalSelesai)->format('Y-m-d');

        $bentrokDetails = DB::table('tbl_detail_trans_pesan')
            ->join('tbl_baliho', 'tbl_detail_trans_pesan.baliho_id', '=', 'tbl_baliho.id')
            ->whereIn('tbl_detail_trans_pesan.baliho_id', $balihoIds)
            ->whereBetween('tbl_detail_trans_pesan.tanggal', [$tanggalMulai, $tanggalSelesai])
            ->select('tbl_baliho.nama_baliho', 'tbl_baliho.lokasi_baliho', 'tbl_detail_trans_pesan.tanggal')
            ->orderBy('tbl_detail_trans_pesan.tanggal', 'asc')
            ->get();

        if ($bentrokDetails->isNotEmpty()) {
            $bentrokInfo = $bentrokDetails->map(function ($detail) {
                return [
                    'lokasi' => $detail->lokasi_baliho,
                    'nama_baliho' => $detail->nama_baliho,
                    'tanggal' => Carbon::parse($detail->tanggal)->format('Y-m-d'),
                ];
            });

            return [
                'bentrok' => true,
                'details' => $bentrokInfo,
            ];
        }

        return ['bentrok' => false];

    }

    public function simpanPesanan(Request $request)
    {
        $request->validate([
            'reservation' => ['required', 'regex:/^\d{4}-\d{2}-\d{2} \- \d{4}-\d{2}-\d{2}$/'],
            'baliho_ids' => 'required|array|min:1',
            'no_surat' => 'required|string',
            'tgl_surat' => 'required|date',
            'perihal_surat' => 'required|string',
            'surat_permohonan' => 'required|file|mimes:pdf|max:2048',
            'desain_baliho' => 'required|file|mimes:png|max:5120',
            'upload_lepas_baliho' => 'required|file|mimes:png|max:5120',
            'name' => 'required|string',
            'telepon' => 'required|regex:/^[0-9]+$/',
            'instansi' => 'required|exists:tbl_instansi,id',
            'keterangan_event' => 'required|string',
        ]);

        $dates = explode(' - ', $request->reservation);
        $tanggalMulai = Carbon::createFromFormat('Y-m-d', $dates[0]);
        $tanggalSelesai = Carbon::createFromFormat('Y-m-d', $dates[1]);

        $result = $this->cekTanggalLogic($request->baliho_ids, $tanggalMulai, $tanggalSelesai);

        if ($result['bentrok']) {
            $errorMessages = collect($result['details'])->map(function ($detail) {
                return "Baliho <strong>{$detail['nama_baliho']}</strong> di lokasi <strong>{$detail['lokasi']}</strong> sudah digunakan pada tanggal <strong>{$detail['tanggal']}</strong>.";
            })->implode('<br>');

            Log::error("Penyimpanan dibatalkan karena bentrok: " . json_encode($result['details']));

            return redirect()->route('pesanmesi.pesan')->with('error', $errorMessages);
        }




        $suratPath = $request->file('surat_permohonan')->store('surat_permohonan');
        $desainPath = $request->file('desain_baliho')->store('desain_baliho');
        $lepasPath = $request->file('upload_lepas_baliho')->store('upload_lepas_baliho');

        $kodeTransaksi = $this->generateKodeTransaksi();

        foreach ($request->baliho_ids as $balihoId) {
            DB::table('tbl_pesan')->insert([
                'id' => (string) Str::uuid(),
                'kode_trans' => $kodeTransaksi,
                'baliho_id' => $balihoId,
                'user_id' => Auth::id(),
                'instansi_id' => $request->instansi,
                'level_id' => '6b253084-0274-4b22-8536-17593edc4701',
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'keterangan_event' => strtoupper(e($request->keterangan_event)),
                'upload_surat' => $suratPath,
                'no_surat' => strtoupper(e($request->no_surat)),
                'tgl_surat' => $request->tgl_surat,
                'perihal_surat' => strtoupper(e($request->perihal_surat)),
                'upload_desain' => $desainPath,
                'upload_lepas_baliho' => $lepasPath,
                'nama_pic' => strtoupper(e($request->name)),
                'tlp_pic' => e($request->telepon),
                'status_pakai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $startDate = $tanggalMulai->copy();
            $endDate = $tanggalSelesai->copy();
            $datesToInsert = [];

            while ($startDate <= $endDate) {
                $datesToInsert[] = [
                    'kode_trans_fk' => $kodeTransaksi,
                    'tanggal' => $startDate->format('Y-m-d'),
                    'baliho_id' => $balihoId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $startDate->addDay();
            }

            DB::table('tbl_detail_trans_pesan')->insert($datesToInsert);
        }

        return redirect()->route('pesanmesi.pesan')->with('success', 'Data berhasil disimpan.');
    }
}
