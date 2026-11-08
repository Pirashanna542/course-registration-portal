<?php

use App\Models\Course;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

public function create(Course $course)
{
    return view('registrations.create', compact('course'));
}

public function store(Request $request, Course $course)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('registrations')
                ->where('course_id', $course->id)
        ],
        'phone' => 'required|string|max:20'
    ]);

    $data['course_id'] = $course->id;

    Registration::create($data);

    return redirect('/')
        ->with('success', 'Registration successful!');
}
