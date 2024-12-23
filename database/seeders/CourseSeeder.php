<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course; // Make sure to import the Course model
use App\Models\User; // We need this to assign instructor_id
use Faker\Factory as Faker;
class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create(); // Create an instance of Faker

        // Find the user with the name 'William'
        $instructor ="William"; // User::where('name', 'William')->first(); // Fetch instructor named William

        // Ensure that the instructor exists
        if ($instructor) {
            // Create 20 courses
            foreach (range(1, 20) as $index) {
                Course::create([
                    'title' => $faker->sentence(3), // Random course title
                    'description' => $faker->paragraph(), // Random course description
                    'course_image' => 'course3.jpg', // Dummy image URL
                    'status' => 'active', // Status of the course (active/paused)
                    'video'=>'motion-video.mp4',
                ]);
            }
        } else {
            echo "Instructor 'William' not found.";
        }
    }
}
