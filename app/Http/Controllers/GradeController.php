<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index1()
    {
        $grades = Grade::with(['student', 'course'])->get();
        return view('grades.index', compact('grades'));
    }

    public function index2(Request $request)
    {
        $search = $request->input('search');
        $filterCourseId = $request->input('filter_course_id');
        $filterGrade = $request->input('filter_grade');

        // Get all courses and distinct grades for filter dropdowns
        $courses = Course::all();
        // For distinct grades, we can fetch them from the grades table directly or define a set of common grades.
        // Let's assume common grades for now, or fetch distinct ones from existing grades if there are many variations.
        // For a more robust solution, consider a dedicated 'GradeType' model or enum if grades are fixed.
        // For simplicity, let's get distinct grades that are currently assigned.
        $distinctGrades = Grade::select('grade')->distinct()->pluck('grade')->sort()->toArray();

        $grades = Grade::query()
            ->with(['student', 'course']) // Eager load relationships for efficient querying and display

            // Apply search functionality
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('grade', 'like', '%' . $search . '%') // Search by grade value
                             ->orWhereHas('student', function ($studentQuery) use ($search) {
                                 $studentQuery->where('first_name', 'like', '%' . $search . '%')
                                              ->orWhere('last_name', 'like', '%' . $search . '%');
                             })
                             ->orWhereHas('course', function ($courseQuery) use ($search) {
                                 $courseQuery->where('name', 'like', '%' . $search . '%')
                                             ->orWhere('code', 'like', '%' . $search . '%');
                             });
                });
            })

            // Apply filter by course
            ->when($filterCourseId, function ($query, $filterCourseId) {
                $query->where('course_id', $filterCourseId);
            })

            // Apply filter by grade
            ->when($filterGrade, function ($query, $filterGrade) {
                $query->where('grade', $filterGrade);
            })

            ->latest() // Order by latest created grades
            ->paginate(10); // Paginate results

        return view('grades.index', compact('grades', 'courses', 'distinctGrades', 'search', 'filterCourseId', 'filterGrade'));
    }


    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterCourseId = $request->input('filter_course_id');
        $filterGrade = $request->input('filter_grade');

        // New: Sorting parameters
        $sortBy = $request->input('sort_by', 'created_at'); // Default sort by creation date
        $sortDirection = $request->input('sort_direction', 'desc'); // Default sort descending

        // Get all courses and distinct grades for filter dropdowns
        $courses = Course::all();
        $distinctGrades = Grade::select('grade')->distinct()->pluck('grade')->sort()->toArray();

        $grades = Grade::query()
            ->with(['student', 'course']) // Eager load relationships for efficient querying and display

            // Apply search functionality
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('grade', 'like', '%' . $search . '%') // Search by grade value
                             ->orWhereHas('student', function ($studentQuery) use ($search) {
                                 $studentQuery->where('first_name', 'like', '%' . $search . '%')
                                              ->orWhere('last_name', 'like', '%' . $search . '%');
                             })
                             ->orWhereHas('course', function ($courseQuery) use ($search) {
                                 $courseQuery->where('name', 'like', '%' . $search . '%')
                                             ->orWhere('code', 'like', '%' . $search . '%');
                             });
                });
            })

            // Apply filter by course
            ->when($filterCourseId, function ($query, $filterCourseId) {
                $query->where('course_id', $filterCourseId);
            })

            // Apply filter by grade
            ->when($filterGrade, function ($query, $filterGrade) {
                $query->where('grade', $filterGrade);
            })

            // New: Apply sorting
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10); // Paginate results

        return view('grades.index', compact('grades', 'courses', 'distinctGrades', 'search', 'filterCourseId', 'filterGrade', 'sortBy', 'sortDirection'));
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