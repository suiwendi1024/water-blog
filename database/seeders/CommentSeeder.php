<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('id', '>', 1)->get();
        $posts = Post::all()->random(20);

        for ($i = 0; $i < 200; $i++) {
            Comment::factory()
                ->for($users->random(), 'owner')
                ->for($posts->random(), 'commentable')
                ->create();
        }
    }
}
