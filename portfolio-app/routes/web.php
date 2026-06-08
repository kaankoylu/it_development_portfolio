<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get('/', function () {
    return view('welcome');
});

// REMOVED BECAUSE IT CAUSED ME TO VISIT THE DEFULT DASHBOARD PAGE INSTEAD OF owner/dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::patch('/owner/posts/{post}', [PortfolioController::class, 'updatePostStatus'])->name('owner.post.update');
    Route::post('/owner/courses', [PortfolioController::class, 'storeCourse'])->name('owner.course.store');
});

require __DIR__.'/auth.php';
