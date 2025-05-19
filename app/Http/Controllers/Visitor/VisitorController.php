<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function countVisitors()
    {
        $today = now()->toDateString();

        $totalVisitors = DB::table('visitors')->count();
        $todayVisitors = DB::table('visitors')
            ->whereDate('visited_at', $today)
            ->count();

        return response()->json([
            'total_visitors' => $totalVisitors,
            'today_visitors' => $todayVisitors,
        ]);
    }
}
