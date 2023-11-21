<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courseNames = [
            "Introduction to Computer Science",
            "Data Structures and Algorithms",
            "Web Development",
            "Machine Learning",
            "Database Management",
            "Software Engineering",
            "Artificial Intelligence",
            "Cybersecurity",
            "Mobile App Development",
            "Operating Systems",
        ];

        foreach ($courseNames as $courseName) {
            Course::create(['name' => $courseName]);
        }
    }
}
