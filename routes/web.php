<?php
    use App\Http\Controllers\AnalisisLog\AnalisisLogController;
    use App\Http\Controllers\Dashboard\DashboardController;
    use App\Http\Controllers\PesanMesi\PesanMesiController;
    use App\Http\Controllers\KodeAkun\KodeAkunController;
    use App\Http\Controllers\Instansi\InstansiController;
    use App\Http\Controllers\Visitor\VisitorController;
    use App\Http\Controllers\Laporan\LaporanController;
    use App\Http\Controllers\Baliho\BalihoController;
    use App\Http\Controllers\Level\LevelController;
    use App\Http\Controllers\User\UserController;
    use App\Http\Controllers\Auth\AuthController;
    use Illuminate\Support\Facades\Artisan;
    use App\Http\Middleware\RoleMiddleware;
    use App\Http\Controllers\AnalisisLog;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return redirect()->route('login.form');
    });

     // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.sa');

    Route::get('/visitor-counter', [VisitorController::class, 'countVisitors']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware(['auth', 'role:SA'])->group(function () {
        Route::get('/dashboard/sa', [DashboardController::class, 'saDashboard'])
            ->name('dashboard.sa');

             // pesan mesi
            Route::get('/pesanmesi/pesan', [PesanMesiController::class, 'generateKodeTransaksi'])->name('pesanmesi.pesan');
            Route::get('/pesanmesi', [PesanMesiController::class, 'index'])->name('pesanmesi.pesan');
            Route::post('/pesanmesi/simpanpesanan', [PesanMesiController::class, 'simpanPesanan'])->name('pesanmesi.simpanpesanan');
            Route::post('/pesanmesi/cekTanggal', [PesanMesiController::class, 'cekTanggal'])->name('pesanmesi.cekTanggal');
            Route::get('/pesanmesi/rekapbaliho', [PesanMesiController::class, 'rekapbaliho'])->name('pesanmesi.rekapbaliho');
            Route::delete('/pesanmesi/hapusorderbaliho/{id}', [PesanMesiController::class, 'hapusOrderBaliho'])->name('pesanmesi.hapusorderbaliho.delete');

            // analisis log
            Route::get('/analisislog', [AnalisisLogController::class, 'index'])->name('analisislog.analisis-log');

             // instansi
            Route::get('/instansi', [InstansiController::class, 'index'])->name('instansi.index');
            Route::get('/instansi-cari', [InstansiController::class, 'instansiCari'])->name('instansi.cari');
            Route::get('/instansi-data', [InstansiController::class, 'getDataInstansi'])->name('instansi.data');
            Route::post('/instansi-simpan', [InstansiController::class, 'simpanDataInstansi'])->name('instansi.simpan');
            Route::get('/instansi/{id}/edit', [InstansiController::class, 'editDataInstansi'])->name('instansi.edit');
            Route::put('/instansi/{id}', [InstansiController::class, 'updateDataInstansi'])->name('instansi.update');
            Route::delete('/instansi/{id}', [InstansiController::class, 'hapusDataInstansi'])->name('instansi.hapus');

            // kode akun
            Route::get('/kodeakun', [KodeAkunController::class, 'index'])->name('kodeakun.index');
            Route::get('/kodeakun-data', [KodeAkunController::class, 'getDataKodeAkun'])->name('kodeakun.data');
            Route::post('/kodeakun-simpan', [KodeAkunController::class, 'simpanDataKodeAkun'])->name('kodeakun.simpan');
            Route::get('/kodeakun/{id}/edit', [KodeAkunController::class, 'editDataKodeAkun'])->name('kodeakun.edit');
            Route::put('/kodeakun/{id}', [KodeAkunController::class, 'updateDataKodeAkun'])->name('kodeakun.update');
            Route::delete('/kodeakun/{id}', [KodeAkunController::class, 'hapusDataKodeAkun'])->name('kodeakun.hapus');

            // level
            Route::get('/level', [LevelController::class, 'index'])->name('level.index');
            Route::get('/level-data', [LevelController::class, 'getDataLevel'])->name('level.data');
            Route::post('/level-simpan', [LevelController::class, 'simpanDataLevel'])->name('level.simpan');
            Route::get('/level/{id}/edit', [LevelController::class, 'editDataLevel'])->name('level.edit');
            Route::put('/level/{id}', [LevelController::class, 'updateDataLevel'])->name('level.update');
            Route::delete('/level/{id}', [LevelController::class, 'hapusDataLevel'])->name('level.hapus');

            // user
            Route::get('/user', [UserController::class, 'index'])->name('user.index');
            Route::get('/user-data', [UserController::class, 'getDataUser'])->name('user.data');
            Route::post('/user-simpan', [UserController::class, 'simpanDataUser'])->name('user.simpan');
            Route::get('/user/{id}/edit', [UserController::class, 'editDataUser'])->name('user.edit');
            Route::put('/user/{id}', [UserController::class, 'updateDataUser'])->name('user.update');
            Route::delete('/user/{id}', [UserController::class, 'hapusDataUser'])->name('user.hapus');

            // baliho
            Route::get('/baliho', [BalihoController::class, 'index'])->name('baliho.index');
            Route::get('/baliho-data', [BalihoController::class, 'getDataBaliho'])->name('baliho.data');
            Route::post('/baliho-simpan', [BalihoController::class, 'simpanDataBaliho'])->name('baliho.simpan');
            Route::get('/baliho/{id}/edit', [BalihoController::class, 'editDataBaliho'])->name('baliho.edit');
            Route::put('/baliho/{id}', [BalihoController::class, 'updateDataBaliho'])->name('baliho.update');
            Route::delete('/baliho/{id}', [BalihoController::class, 'hapusDataBaliho'])->name('baliho.hapus');

            // Laporan
            Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('/laporan/laporan-events', [LaporanController::class, 'getBalihoEvents'])->name('laporan.laporan-events');
    });

    // ROUTE TAMBAHAN
    // Route::get('/storagelink', function () {
    //     Artisan::call('storage:link');
    //     return redirect('/');
    // });
