<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Biography;
use App\Models\CourseProgress;
use Illuminate\Http\JsonResponse;

class ShowcaseApiController extends Controller
{
    // Summary Statistics endpoint
    public function getStats(): JsonResponse
    {
        $courses = CourseProgress::all();

        return response()->json([
            'meta' => [
                'system_time' => now()->toIso8601String(),
                'status' => 'healthy'
            ],
            'data' => [
                'total_courses_logged' => $courses->count(),
                'completed_courses' => $courses->where('status', 'completed')->count(),
                'total_ec_achieved' => (int) $courses->where('status', 'completed')->sum('credits_ec'),
            ]
        ]);
    }

    // Profiles endpoint
    public function getProfile(): JsonResponse
    {
        $bio = Biography::first();

        if (!$bio) {
            return response()->json(['error' => 'No core bio context set yet.'], 404);
        }

        // Explode the raw string properties directly into structural JSON nodes
        $skillsArray = array_map('trim', explode(',', $bio->skills));

        return response()->json([
            'profile' => [
                'name' => $bio->full_name,
                'headline' => $bio->title,
                'skills_inventory' => $skillsArray,
            ]
        ]);
    }
}
