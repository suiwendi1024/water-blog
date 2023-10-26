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
        $users = User::limit(10)->get();
        $posts = Post::limit(20)->get();

        foreach ($posts as $i => $post) {
            Comment::factory()
                ->count(3)
                ->for($users->get($i % $users->count()), 'owner')
                ->for($post, 'commentable')
                ->create();

            Comment::factory()
                ->count(15)
                ->for(User::factory()->create(), 'owner')
                ->for($post, 'commentable')
                ->create();
        }
    }
}
