<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Автор статьи',
            'email' => 'user@example.com',
        ]);

        Article::factory()
            ->for($user)
            ->has(Tag::factory()->count(3))
            ->count(50)
            ->create();
    }
}
