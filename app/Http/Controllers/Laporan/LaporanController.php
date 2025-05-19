<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\PesanMesi\PesanMesiController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PesanMesi;
use App\Models\Instansi;
use App\Models\Baliho;
use App\Models\Level;
use App\Models\User;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function getBalihoEvents(Request $request)
    {
        $events = DB::table('tbl_pesan')
            ->join('tbl_baliho', 'tbl_pesan.baliho_id', '=', 'tbl_baliho.id')
            ->join('tbl_instansi', 'tbl_pesan.instansi_id', '=', 'tbl_instansi.id')
            ->join('users', 'tbl_pesan.user_id', '=', 'users.id')
            ->select(
                'tbl_baliho.nama_baliho as title',
                'tbl_pesan.tanggal_mulai as start',
                'tbl_pesan.tanggal_selesai as end',
                'tbl_pesan.keterangan_event as detail',
                'tbl_instansi.instansi as instansi',
                'tbl_pesan.nama_pic as name',
                'tbl_baliho.id as baliho_id'
            )->orderBy('tbl_pesan.tanggal_mulai', 'DESC')->get();

            if ($request->ajax()) {
                return DataTables::of($events)
                    ->addColumn('tanggal_event', function ($row) {
                        return \Carbon\Carbon::parse($row->start)->format('d M Y') . ' - ' .
                        \Carbon\Carbon::parse($row->end)->format('d M Y');
                    })
                    ->addColumn('detail', function ($row) {
                        return $row->detail;
                    })
                    ->make(true);
            }

            return view('laporan.index', compact('events'));
    }
}
