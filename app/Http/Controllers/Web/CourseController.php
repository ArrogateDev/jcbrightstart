<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index()
    {
    }

    public function show(Course $course)
    {
        $course->load([
            'chapters:id,course_id,title',
            'chapters.units',
            'chapters.units.quiz:id,title'
        ]);

//        print_r($course->toArray());
        return view('web.course.show', compact('course'));
    }
}
