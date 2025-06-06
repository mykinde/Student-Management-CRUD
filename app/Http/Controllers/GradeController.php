<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'course'])->get();
        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('grades.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|string|max:10',
        ]);

        // Check for unique student-course combination
        if (Grade::where('student_id', $request->student_id)->where('course_id', $request->course_id)->exists()) {
            return redirect()->back()->withErrors(['message' => 'This student already has a grade for this course.'])->withInput();
        }

        Grade::create($request->all());
        return redirect()->route('grades.index')->with('success', 'Grade assigned successfully.');
    }

    public function show(Grade $grade)
    {
        $grade->load(['student', 'course']);
        return view('grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        $students = Student::all();
        $courses = Course::all();
        return view('grades.edit', compact('grade', 'students', 'courses'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|string|max:10',
        ]);

        // Check for unique student-course combination, excluding the current grade
        if (Grade::where('student_id', $request->student_id)
                 ->where('course_id', $request->course_id)
                 ->where('id', '!=', $grade->id)
                 ->exists()) {
            return redirect()->back()->withErrors(['message' => 'This student already has a grade for this course.'])->withInput();
        }

        $grade->update($request->all());
        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}