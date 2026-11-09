<?php

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/courses', function () {
    $courses = Course::all();
    return response()->json([
        'success' => true,
        'count' => $courses->count(),
        'data' => $courses
    ], 200);
});