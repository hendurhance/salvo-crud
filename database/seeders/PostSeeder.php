<?php

namespace Database\Seeders;

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
        // Get users with roles developer and super-admin
        $users = User::role(['developer', 'super-admin'])->get();
        // Create 10 posts for each user
        $users->each(function ($user) {
            $user->posts()->createMany(
                Post::factory()->count(10)->make()->toArray()
            );
        });
    }
}
