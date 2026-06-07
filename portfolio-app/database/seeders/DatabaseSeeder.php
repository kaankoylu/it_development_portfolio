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
     * fpr seeding the application's database, everything handles here instead of seperate files because there is not too much need for it
     */
    public function run(): void
    {

        // creating the admin profile
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // default biography
        Biography::updateOrCreate(
            ['id' => 1],
            [
                'full_name' => 'John Doe',
                'title' => 'Software Engineer in Training',
                'bio_text' => 'Welcome to my raw portfolio showcase app built with Laravel Sail.',
                'skills' => 'PHP, Laravel, Docker, Arch Linux'
            ]
        );

        // clearing old sample data to stop the duplicates
        Post::truncate();
        CourseProgress::truncate();

        // this is the BLOG page workflow, i fill it with mock information for showcase purposes, texts are ai generated.
        // also, blog posts has different "status" every status has a differnet consequence.
        //DRAFT means visitors cant see it, REVIEW means it should be checked but done, PUBLISHED means it is seenable by everyone
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

        // Academic Progress Samples
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
            'grade' => null, //null for now, will check it out when i have time ****FLAG******
        ]);
    }
}
