<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Arr;
use App\Models\StudentCourse;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * assign each students with min 1, max 3 course.
     */
    public function run(): void
    {
        $students = Student::all();
        $courseIds = Course::pluck('id')->toArray();

        $factoryData = [];

        foreach ($students as $student) {
            $temp_course = $courseIds;
            $couse_count = rand(1, 3);
            for($i = 0; $i <= $couse_count; $i++) {

                $random = array_rand($temp_course);
                $courseId = $temp_course[$random];

                $factoryData[] = [
                    'student_id' => $student->id,
                    'course_id' => $courseId,
                ];

                $temp_course = array_values(array_diff($temp_course, [$courseId]));
            }
        }
        foreach ($factoryData as $data) {
            StudentCourse::create($data);
        }
    }
}
