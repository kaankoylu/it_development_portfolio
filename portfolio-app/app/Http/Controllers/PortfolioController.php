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
            'full_name' => 'John Doe',
            'title' => 'Software Engineer in Training',
            'bio_text' => 'Welcome to my raw portfolio showcase app.',
            'skills' => 'PHP, Laravel, Docker'
        ]);

        $posts = Post::where('status', 'published')->latest()->get();
        $courses = CourseProgress::all();

        // this one calculates dashboard status by the credis earned
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
    {if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->email !== 'admin@showcase.com') {
        abort(403, 'Unauthorized action. OWASP A01 Access Control Check Failed.');
    }}
}
