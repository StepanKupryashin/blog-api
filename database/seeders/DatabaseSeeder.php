<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // for($i = 0; $i < 10; $i++) {
        //     Post::create([
        //         'name' => 'Тестовый пост',
        //         'author' => 12,
        //         'text' => Lorem::text(),
        //         'image' => 'images/post.jpg',
        //     ]);
        // }
    }
}
