<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'credits_ec' => 'required|numeric',
            'status' => 'required',
            'grade' => 'nullable|numeric|between:1,10',
        ]);

        Course::create($validated);

        return redirect()->route('owner.dashboard')->with('success', 'Course logged successfully!');
    }

    /**
     * Show the form for editing a specific course.
     */
    public function edit(Course $course)
    {
        return view('owner.course.edit', compact('course'));
    }

    /**
     * Update a specific course.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'credits_ec' => 'required|numeric',
            'status' => 'required',
            'grade' => 'nullable|numeric|between:1,10',
        ]);

        $course->update($validated);

        return redirect()->route('owner.dashboard')->with('success', 'Course updated successfully!');
    }

    /**
     * Bulk update multiple courses from the dashboard.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'courses' => 'required|array'
        ]);

        foreach ($request->courses as $id => $data) {
            $course = Course::findOrFail($id);
            $course->update([
                'course_name' => $data['course_name'],
                'credits_ec' => $data['credits_ec'],
                'status' => $data['status'],
                'grade' => $data['grade'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'All courses updated successfully!');
    }

    /**
     * Delete a course.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('owner.dashboard')->with('success', 'Course deleted.');
    }
}
