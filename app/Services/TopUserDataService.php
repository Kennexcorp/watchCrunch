<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TopUserDataService
{
    public function __construct()
    {
    }

    public function topUserData(int $noOfDays = 7, int $maxPostCount = 10): array
    {

        $topUsersData = [];

        User::query()->with('posts')->chunk(100, function ($users) use (&$topUsersData, $noOfDays, $maxPostCount) {
            foreach ($users as $user) {

                $userPosts = $user->posts->where('created_at', '>=', Carbon::now()->subDays($noOfDays));
                $userLatestPost = $userPosts->last();
                $postCount = $userPosts->count();

                if ($postCount > $maxPostCount) {
                    $topUsersData[]  = [
                        'username' => $user->username,
                        'total_posts_count' => $postCount,
                        'last_post_title' => $userLatestPost->title
                    ];
                }
            }
        });

        return $topUsersData;
    }
}
