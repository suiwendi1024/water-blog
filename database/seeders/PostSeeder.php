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
        $users = User::where('id', '>', 1)->get();
        $categories = Category::where('id', '>', 1)->get();

        for ($i = 0; $i < 100; $i++) {
            Post::factory()
                ->for($users->random(), 'author')
                ->for($categories->random())
                ->create();
        }
    }
}
