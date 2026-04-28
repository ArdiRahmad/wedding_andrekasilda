<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\WaTemplateController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Auth;

Route::post('/rsvp', [FrontendController::class, 'rsvp']);

// Cukup panggil satu kali saja
Auth::routes();

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    
    Route::get('guests/export', [GuestController::class, 'export'])->name('guests.export');
    Route::post('guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::get('guests/download-template', [GuestController::class, 'downloadTemplate'])->name('guests.download-template');
    Route::resource('guests', GuestController::class);

    Route::get('wishes', [GuestController::class, 'wishes'])->name('wishes.index');
    Route::post('guests/{guest}/toggle-wishes', [GuestController::class, 'toggleWishes'])->name('guests.toggle-wishes');

    Route::get('broadcast', [GuestController::class, 'broadcast'])->name('broadcast.index');
    Route::post('guests/{guest}/mark-sent', [GuestController::class, 'markAsSent'])->name('guests.mark-sent');

    // WA Templates
    Route::post('wa-templates/{wa_template}/set-active', [WaTemplateController::class, 'setActive'])->name('wa-templates.set-active');
    Route::resource('wa-templates', WaTemplateController::class);

    // Settings
    Route::get('change-password', [SettingController::class, 'changePassword'])->name('password.change');
    Route::post('change-password', [SettingController::class, 'updatePassword'])->name('password.update');
});

Route::get('/aft', [FrontendController::class, 'index']);
Route::get('/mrn', [FrontendController::class, 'index']);
Route::get('/{code?}', [FrontendController::class, 'index']);