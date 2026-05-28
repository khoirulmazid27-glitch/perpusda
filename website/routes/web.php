<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('karyawan', KaryawanController::class);

// ── Export ───────────────────────────────────────────────────────────────────
Route::get('karyawan-export-excel', [KaryawanController::class, 'exportExcel'])
    ->name('karyawan.export.excel');

Route::get('karyawan-export-pdf', [KaryawanController::class, 'exportPdf'])
    ->name('karyawan.export.pdf');

// ── Import ───────────────────────────────────────────────────────────────────
Route::post('karyawan-import', [KaryawanController::class, 'importExcel'])
    ->name('karyawan.import');

// ── Hapus Foto ───────────────────────────────────────────────────────────────
Route::delete('karyawan/{karyawan}/foto', [KaryawanController::class, 'deleteFoto'])
    ->name('karyawan.delete-foto');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
