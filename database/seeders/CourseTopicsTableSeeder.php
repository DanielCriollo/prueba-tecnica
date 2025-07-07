<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseTopic;
use Carbon\Carbon;

class CourseTopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseTopic::insert([
            [
                'name' => 'Introduction to Programming',
                'description' => 'Covers fundamental programming concepts and logic building.',
                'publication_date' => Carbon::parse('2023-01-15'),
                'is_mandatory' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Data Structures',
                'description' => 'Explains arrays, linked lists, stacks, queues, and trees.',
                'publication_date' => Carbon::parse('2023-02-01'),
                'is_mandatory' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Web Development Basics',
                'description' => 'Introduction to HTML, CSS, and basic JavaScript.',
                'publication_date' => Carbon::parse('2023-03-10'),
                'is_mandatory' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Software Testing Fundamentals',
                'description' => 'Overview of unit testing, integration testing, and QA processes.',
                'publication_date' => Carbon::parse('2023-04-05'),
                'is_mandatory' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
