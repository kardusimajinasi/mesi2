<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Models\Baliho;
use App\Models\Level;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {
        $user= Auth::user();

        $instansi = Instansi::find($user->instansi_id);

        $userData = DB::table('users')
            ->join('tbl_instansi', 'users.instansi_id', '=', 'tbl_instansi.id')
            ->join('tbl_lvl', 'users.level_id', '=', 'tbl_lvl.id')
            ->where('users.id', '=', $user->id)
            ->select('users.username', 'tbl_instansi.instansi', 'tbl_lvl.level')
            ->first();

        if (!$userData) {
            return redirect()->route('dashboard')->with('error', 'Instansi tidak ditemukan');
        }

        $totalBaliho = DB::table('tbl_baliho')->count();


        $terpakaiBaliho = DB::table('tbl_pesan')->where('status_pakai', '1')->count();

        // Kirim data ke view
        return view('dashboard.index', [
            'username' => $userData->username,
            'instansi' => $userData->instansi,
            'level' => $userData->level,
            'totalBaliho' => $totalBaliho,
            'terpakaiBaliho' => $terpakaiBaliho,
        ]);
    }

    public function userDashboard()
    {
        return view('dashboard.user', ['user' => Auth::user()]);
    }

    public function adminDashboard()
    {
        return view('dashboard.admin', ['user' => Auth::user()]);
    }

    public function saDashboard()
    {
        $user = Auth::user();
        $totalBaliho = DB::table('tbl_baliho')->count();
        $terpakaiBaliho = DB::table('tbl_detail_trans_pesan')
            ->join('tbl_pesan', 'tbl_detail_trans_pesan.kode_trans_fk', '=', 'tbl_pesan.kode_trans')
            ->where('tbl_pesan.status_pakai', '1')
            ->distinct('tbl_detail_trans_pesan.baliho_id')
            ->count('tbl_detail_trans_pesan.baliho_id');

        $tersediaBaliho = $totalBaliho - $terpakaiBaliho;


        return view('dashboard.sa', [
            'user' => $user,
            'totalBaliho' => $totalBaliho,
            'terpakaiBaliho' => $terpakaiBaliho,
            'tersediaBaliho' => $tersediaBaliho,
        ]);
        // return view('dashboard.sa', ['user' => Auth::user()]);
    }
}
