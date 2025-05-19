<?php

namespace App\Http\Controllers\AnalisisLog;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use app\Models\AnalisisLog;

class AnalisisLogController extends Controller
{
    public function index()
    {
        return view('analisislog.analisis-log');
    }
}
