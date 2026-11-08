<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index() {
        $courses = Course::all();
        return view('welcome', compact('courses'));
    }

    public function storeRegistration(Request $request, Course $course) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Check if already registered with same email for this course
        $exists = Registration::where('course_id', $course->id)
                              ->where('email', $request->email)
                              ->exists();

        if ($exists) {
            return back()->withErrors(['email' => 'This email is already registered for this course.']);
        }

        Registration::create([
            'course_id' => $course->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Successfully registered for the course!');
    }
}
