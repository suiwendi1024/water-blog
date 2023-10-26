<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::limit(10)->get();
        $categories = Category::all();

        foreach ($users as $i => $user) {
            Post::factory()
                ->count(3)
                ->for($user, 'author')
                ->for($categories->get($i % $categories->count()))
                ->create();
        }
    }
}
