<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public Home Page (Course Registration Portal)
Route::get('/', [PublicController::class, 'index']);

// Student Course Registration Route
Route::post('/courses/{course}/register', [PublicController::class, 'storeRegistration'])->name('register.course');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('courses', CourseController::class)->except(['show']);
});

require __DIR__.'/auth.php';