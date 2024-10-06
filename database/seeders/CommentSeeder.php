<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray();
        $postIds = Post::pluck('id')->toArray();

        for ($i = 0; $i < 15; $i++) {
            Comment::create([
                'comment' => Str::random(50), 
                'user_id' => $userIds[array_rand($userIds)], 
                'post_id' => $postIds[array_rand($postIds)], 
            ]);
        }
    }
}
