<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('id', '>', 1)->get();
        $posts = Post::has('comments')->get()->random(20);

        for ($i = 0; $i < 100; $i++) {
            auth()->setUser($users->random());
            $posts->random()->like();
        }

        $comments = Comment::all()->random(20);

        for ($i = 0; $i < 200; $i++) {
            auth()->setUser($users->random());
            $comments->random()->like();
        }
    }
}
