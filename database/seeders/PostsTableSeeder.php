<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User; 

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray(); 

       
        for ($i = 1; $i <= 5; $i++) {
            Post::create([
                'title' => "Post Title $i",
                'content' => "Content of post $i.",
                'user_id' => $userIds[array_rand($userIds)], 
            ]);
        }
    }
}
