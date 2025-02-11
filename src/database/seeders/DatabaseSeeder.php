<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin'
        ]);

        \App\Models\Student::factory()->create([
            'name' => 'ambrose83',
            'email' => 'ambrose83@example.org'
        ]);
        \App\Models\Student::factory(9)->create();

        $this->call(CourseSeeder::class);
        $this->call(StudentCourseSeeder::class);
    }
}
