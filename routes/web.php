<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\Paiementcontroller;
use App\Http\Controllers\BesoinController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth'])->group(function () {
    
    // Etudiants
Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiants.create');
Route::post('/etudiants/store', [EtudiantController::class, 'store'])->name('etudiants.store');
Route::get('/etudiants/{etudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');
Route::get('/etudiants/{etudiant}/edit', [EtudiantController::class, 'edit'])->name('etudiants.edit');
Route::put('/etudiants/{etudiant}/update', [EtudiantController::class, 'update'])->name('etudiants.update');
Route::delete('/etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');

    // Paiements
Route::get('/paiements', [Paiementcontroller::class, 'index'])->name('paiements.index');
Route::get('/paiements/create/{etudiant}', [Paiementcontroller::class, 'create'])->name('paiements.create');
Route::post('/paiements/store', [Paiementcontroller::class, 'store'])->name('paiements.store');
Route::get('/paiements/receipt/{paiement}', [Paiementcontroller::class, 'showReceipt'])->name('paiements.receipt');

    // Besoins
Route::get('/besoins', [BesoinController::class, 'index'])->name('besoins.index');
Route::post('/besoins', [BesoinController::class, 'store'])->name('besoins.store');

    // API pour charger les inscriptions d'un étudiant
Route::get('/api/etudiants/{etudiant}/inscriptions', [EtudiantController::class, 'getInscriptions']);
Route::post('/etudiants/{etudiant}/inscriptions', [EtudiantController::class, 'addInscription'])->name('etudiants.inscriptions.store');
});
