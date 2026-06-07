<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\CourseProgress;
use App\Models\Biography;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Create a default Bio record
        Biography::updateOrCreate(
            ['id' => 1],
            [
                'full_name' => 'John Doe',
                'title' => 'Software Engineer in Training',
                'bio_text' => 'Welcome to my raw portfolio showcase app built with Laravel Sail.',
                'skills' => 'PHP, Laravel, Docker, Arch Linux'
            ]
        );

        // 3. Clear old sample data to avoid duplicates on re-run
        Post::truncate();
        CourseProgress::truncate();

        // 4. Create Blog Workflow Samples
        Post::create([
            'title' => 'My First Draft Idea',
            'content' => 'This is a draft post. Visitors should NOT be able to see this on the homepage.',
            'status' => 'draft',
        ]);

        Post::create([
            'title' => 'An Article Under Review',
            'content' => 'This article is finished but waiting for a final review check.',
            'status' => 'review',
        ]);

        Post::create([
            'title' => 'Hello World! My First Published Post',
            'content' => 'Success! Because this status is set to published, it will visible to the general public.',
            'status' => 'published',
        ]);

        // 5. Create Academic Progress Samples
        CourseProgress::create([
            'course_name' => 'Introduction to Software Engineering',
            'credits_ec' => 5,
            'status' => 'completed',
            'grade' => 8.5,
        ]);

        CourseProgress::create([
            'course_name' => 'Databases and Persistent Data',
            'credits_ec' => 5,
            'status' => 'in_progress',
            'grade' => null,
        ]);
    }
}
