<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Models\Course;
use App\Models\Registration;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $courses = Course::latest()->get();
    return view('welcome', compact('courses'));
});

// Student Course Registration Route (Added to fix the error)
Route::post('/courses/{course}/register', function (Request $request, Course $course) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
    ]);

    // Check if the email is already registered for this course
    $exists = Registration::where('course_id', $course->id)
                          ->where('email', $request->email)
                          ->exists();

    if ($exists) {
        return back()->with('error', 'This email is already registered for this course.');
    }

    // Save registration
    Registration::create([
        'course_id' => $course->id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    return back()->with('success', 'Successfully registered for ' . $course->title . '!');
})->name('courses.register');

// Admin & User Dashboards
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/user/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Course Management Routes (Added Edit, Update & Destroy routes)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/courses', function () {
        $courses = Course::latest()->get();
        return view('admin.courses.index', compact('courses'));
    })->name('courses.index');

    Route::get('/courses/create', function () {
        return view('admin.courses.create');
    })->name('courses.create');

    Route::post('/courses', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string|max:255',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    })->name('courses.store');

    Route::get('/courses/{course}/edit', function (Course $course) {
        return view('admin.courses.edit', compact('course'));
    })->name('courses.edit');

    Route::put('/courses/{course}', function (Request $request, Course $course) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string|max:255',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    })->name('courses.update');

    Route::delete('/courses/{course}', function (Course $course) {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    })->name('courses.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';