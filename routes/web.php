<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ===================================================================
// 2. ROLE-BASED DASHBOARDS (Menggunakan Middleware Role)
// ===================================================================

// ADMIN DASHBOARD
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('role_dashboards.admin_dashboard');
    })->name('admin.dashboard');
    // Tambahkan route modul Admin (Users, Categories, Global Report) di sini
});

// MANAGER DASHBOARD
Route::middleware(['auth', 'role:manager,admin'])->group(function () { 
    Route::get('/manager', function () {
        return view('role_dashboards.manager_dashboard');
    })->name('manager.dashboard');
    // Tambahkan route modul Manager (Approval, Low Stock, Restock Overview) di sini
});

// STAFF GUDANG DASHBOARD
Route::middleware(['auth', 'role:staff,admin,manager'])->group(function () {
    Route::get('/staff', function () {
        return view('role_dashboards.staff_dashboard');
    })->name('staff.dashboard');
    // Tambahkan route modul Staff (Input Transaksi Masuk/Keluar, Scanning) di sini
});

// SUPPLIER DASHBOARD
Route::middleware(['auth', 'role:supplier,admin'])->group(function () {
    Route::get('/supplier', function () {
        return view('role_dashboards.supplier_dashboard');
    })->name('supplier.dashboard');
    // Tambahkan route modul Supplier (Manage Restock Order, History) di sini
});
