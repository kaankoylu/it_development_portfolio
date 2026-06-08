<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('welcome');
});

// REMOVED BECAUSE IT CAUSED ME TO VISIT THE DEFULT DASHBOARD PAGE INSTEAD OF owner/dashboard
//***UPDATE*** i brought it back because artisan test was giving errors.
//current difference is IT IS COMPLETELY OVERRIDEN BY AuthTest.php to return owner.dashboard whatever the case is
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public Showcase View
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');

//  Owner/Admin Workspace (Requires authentication login therefore seperate routing then other routes)
Route::middleware(['auth'])->group(function () {
    Route::get('/owner/dashboard', [PortfolioController::class, 'dashboard'])->name('owner.dashboard');
    Route::post('/owner/bio', [PortfolioController::class, 'updateBio'])->name('owner.bio.update');
    Route::post('/owner/posts', [PortfolioController::class, 'storePost'])->name('owner.post.store');
    Route::patch('/owner/posts/bulk-update', [PortfolioController::class, 'bulkUpdatePosts'])->name('owner.posts.bulkUpdate');
    Route::patch('/owner/posts/{post}', [PortfolioController::class, 'updatePostStatus'])->name('owner.post.update');
    Route::delete('/owner/posts/{post}', [PortfolioController::class, 'destroyPost'])->name('owner.post.destroy');
    Route::post('/owner/courses', [PortfolioController::class, 'storeCourse'])->name('owner.course.store');
    Route::post('/owner/course', [CourseController::class, 'store'])->name('owner.course.store');
    Route::get('/owner/course/{course}/edit', [CourseController::class, 'edit'])->name('owner.course.edit');
    Route::put('/owner/course/{course}', [CourseController::class, 'update'])->name('owner.course.update');
    Route::delete('/owner/course/{course}', [CourseController::class, 'destroy'])->name('owner.course.destroy');
    Route::patch('/owner/courses/bulk-update', [CourseController::class, 'bulkUpdate'])->name('owner.courses.bulkUpdate');
});

require __DIR__ . '/auth.php';
