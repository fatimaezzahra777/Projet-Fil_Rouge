<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:patient|medecin|admin'])->group(function () {
    Route::resource('rendezvous', RendezVousController::class);
    Route::patch('/rendezvous/{id}/status', [RendezVousController::class, 'updateStatus'])->name('rendezvous.status');
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/mon-dossier', [PatientController::class, 'dossier'])->name('patient.dossier');
});

Route::middleware(['auth', 'role:medecin'])->group(function () {
    Route::patch('/medecin/points-rendez-vous', [MedecinController::class, 'updateAppointmentCost'])
        ->name('medecins.appointment-cost.update');
});

Route::middleware(['auth', 'role:patient|association'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{contact}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{contact}', [MessageController::class, 'store'])->name('messages.store');
});

Route::resource('patients', PatientController::class);
Route::resource('medecins', MedecinController::class);
Route::resource('associations', AssociationController::class);
Route::resource('activites', ActiviteController::class);

Route::post('/participer/{id}', [ParticipationController::class, 'store'])
    ->name('participer');
Route::patch('/participations/{id}', [ParticipationController::class, 'update'])
    ->middleware(['auth', 'role:association'])
    ->name('participations.update');

require __DIR__.'/auth.php';
