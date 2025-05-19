<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Visitor\VisitorController;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\UsahaRudapaksa;
use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Models\User;
use App\Models\Level;

class AuthController extends Controller
{
    public function authenticated(Request $request, $user)
    {
        if ($user->level->level === 'SA') {
            if ($request->routeIs('dashboard.sa')) {
                return redirect()->route('dashboard.sa');
            }
            return redirect()->route('dashboard.sa');
        }

        Auth::logout();
        return back()->withErrors(['username' => 'Akses tidak valid untuk level pengguna ini.']);
    }


    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.sa');
        }
        $today = now()->toDateString();
        $totalVisitors = DB::table('visitors')->count();
        $todayVisitors = DB::table('visitors')
            ->whereDate('visited_at', $today)
            ->count();

        // return view('auth.login');
        return view('auth.login', compact('totalVisitors', 'todayVisitors'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');

        $loginSuccess = Auth::attempt($request->only('username', 'password'));
        if ($loginSuccess) {
            RateLimiter::clear($this->throttleKey($username));

            return $this->authenticated($request, Auth::user());
        }


        if (RateLimiter::tooManyAttempts($this->throttleKey($username), 3)) {
            return back()->withErrors(['username' => 'Terlalu banyak percobaan login. Silakan coba lagi nanti.']);
        }

        if (Auth::attempt($request->only('username', 'password'))) {
            RateLimiter::clear($this->throttleKey($username));

            $user = User::with('level', 'instansi')->find(Auth::id());

            Log::info('User logged in', [
                'username' => $user->username,
                'level' => $user->level->level,
                'instansi' => $user->instansi->instansi ?? 'N/A',
            ]);

            return $this->authenticated($request, $user);
        }

        RateLimiter::hit($this->throttleKey($username), 60);
        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function logout()
    {
        $username = Auth::user()->username;
        Auth::logout();
        return redirect()->route('login.form');
    }

    protected function throttleKey($username)
    {
        return strtolower($username) . '|' . request()->ip();
    }
}
