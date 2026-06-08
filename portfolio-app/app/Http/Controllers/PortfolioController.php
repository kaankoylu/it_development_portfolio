<?php

namespace App\Http\Controllers;

use App\Models\Biography;
use App\Models\CourseProgress;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PortfolioController extends Controller
{
    // Public view: Visitors see published posts, EC progress, and Bio only
    public function index()
    {
        $bio = Biography::first() ?? new Biography([
            'full_name' => 'Kaan Koylu',
            'title' => 'Software Engineering student',
            'bio_text' => 'Welcome to my raw portfolio showcase app.',
            'skills' => 'PHP, Laravel, Docker'
        ]);

        $posts = Post::where('status', 'published')->latest()->get();
        $courses = CourseProgress::all();

        // this one calculates dashboard status by the credis earned, only sums up if the course marked completed
        // in case the grade is low and course is completed it doesnt matter. it just sums up the credits of the calsses that marked as complet
        $totalEC = $courses->where('status', 'completed')->sum('credits_ec');

        return view('welcome', compact('bio', 'posts', 'courses', 'totalEC'));
    }

    // Admin or Owner Dashboard view (Guarded by gate)
    public function dashboard()
    {
        $this->authorizeOwner();
        $bio = Biography::first();
        $posts = Post::latest()->get();
        $courses = CourseProgress::all();

        return view('owner-dashboard', compact('bio', 'posts', 'courses'));
    }

    // Updating Biographical Info
    public function updateBio(Request $request)
    {
        $this->authorizeOwner();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bio_text' => 'required|string',
            'skills' => 'required|string',
        ]);

        Biography::updateOrCreate(['id' => 1], $validated);

        return redirect()->back()->with('success', 'Biography updated successfully!');
    }

    // manage Blog Posts Workflow
    public function storePost(Request $request)
    {
        $this->authorizeOwner();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,review,published',
        ]);

        Post::create($validated);

        return redirect()->back()->with('success', 'Blog post created successfully!');
    }

    public function updatePostStatus(Request $request, Post $post)
    {
        $this->authorizeOwner();

        $validated = $request->validate([
            'status' => 'required|in:draft,review,published',
        ]);

        $post->update($validated);

        return redirect()->back()->with('success', 'Workflow state updated!');
    }

    // this one is just a update for making the updating in owner page more easy
    // it used to update everyhting individually now it makes it just one button click and everything gets updated
    public function bulkUpdatePosts(Request $request)
    {
        $this->authorizeOwner();

        $validated = $request->validate([
            'posts' => 'required|array',
            'posts.*.title' => 'required|string|max:255',
            'posts.*.content' => 'required|string',
            'posts.*.status' => 'required|in:draft,review,published',
        ]);

        foreach ($request->input('posts') as $id => $data) {
            $post = Post::find($id);
            if ($post) {
                $post->update([
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'status' => $data['status'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'All selected blog articles have been updated.');
    }

    public function destroyPost(Post $post)
    {
        $this->authorizeOwner();

        $post->delete();

        return redirect()->back()->with('success', 'Article removed successfully from database.');
    }

    // sTudy Track Dashboard
    public function storeCourse(Request $request)
    {
        $this->authorizeOwner();

        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'credits_ec' => 'required|integer|min:1',
            'status' => 'required|in:not_started,in_progress,completed',
            'grade' => 'nullable|numeric|between:1,10',
        ]);

        CourseProgress::create($validated);

        return redirect()->back()->with('success', 'Course tracking added!');
    }

    private function authorizeOwner(): void
    {
        if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->email !== 'admin@showcase.com') {
            abort(403, 'Unauthorized action. OWASP A01 Access Control Check Failed.');
        }
    }
}
