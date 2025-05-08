<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Thread;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Response;

class ActivityController extends Controller
{
    /**
     * Get recent activities for the dashboard
     */
    public function index(): Response
    {
        $recentActivity = Activity::with(['user', 'subject'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($activity) {
                $description = match ($activity->type) {
                    'created_thread' => "created thread \"{$activity->subject->title}\"",
                    'created_post' => "commented on \"{$activity->subject->thread->title}\"",
                    'joined_forum' => "joined the forum",
                    'updated_profile' => "updated their profile",
                    default => $activity->description
                };

                return [
                    'id' => $activity->id,
                    'message' => "{$activity->user->name} {$description}",
                    'created_at' => $activity->created_at->diffForHumans()
                ];
            });

        return inertia('Activities/Index', [
            'activities' => $recentActivity
        ]);
    }

    /**
     * Get user-specific activities
     */
    public function userActivities(Request $request): Response
    {
        $activities = Activity::with(['user', 'subject'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return inertia('Activities/UserActivities', [
            'activities' => $activities
        ]);
    }

    /**
     * Clear user activities
     */
    public function clearUserActivities(Request $request): void
    {
        Activity::where('user_id', $request->user()->id)->delete();
    }
}
