<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('id', '>', 1)->get();

        for ($i = 0; $i < 200; $i++) {
            $user = $users->random();
            $followee = $users->random();

            if ($user == $followee) {
                continue;
            }

            auth()->setUser($user);
            $followee->follow();
        }
    }
}
