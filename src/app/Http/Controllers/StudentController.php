<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function list(Request $request)
    {
        $model = Student::with(['courses']);
        if($request->email) {
            $model->where('email', $request->email);
        }

        $students = $model->get();

        $studentsWithCourses = array_filter($students->toArray(), function ($student) {
            return !empty($student['courses']);
        });

        $transformedData = [];
        foreach ($studentsWithCourses as $item) {
            $up_time = Carbon::parse($item['updated_at'])->toDateTimeString();
            $up_diffForHumans = Carbon::createFromFormat('Y-m-d H:i:s', $up_time)->diffForHumans();
            $updated_at = $up_time.'<br>'.$up_diffForHumans;

            $create_time = Carbon::parse($item['created_at'])->toDateTimeString();
            $create_diffForHumans = Carbon::createFromFormat('Y-m-d H:i:s', $create_time)->diffForHumans();
            $created_at = $create_time.'<br>'.$create_diffForHumans;

            $transformedItem = [
                'id' => $item['id'],
                'name' => $item['name'],
                'email' => $item['email'],
                'courses' => array_map(function ($course) {
                    $a = (object)array();
                    $a->id = $course['id'];
                    $a->name = $course['name'];
                    return $a;
                }, $item['courses']),
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ];
            $transformedData[] = $transformedItem;
        }
        return response()->json(['content' => $transformedData], 200);
    }
}
