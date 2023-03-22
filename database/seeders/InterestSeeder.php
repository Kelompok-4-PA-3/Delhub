<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Interest::create([
            'name' => 'Programming',
            'slug' => 'programming',
        ]);

        \App\Models\Interest::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);

        \App\Models\Interest::create([
            'name' => 'Marketing',
            'slug' => 'marketing',
        ]);

        \App\Models\Interest::create([
            'name' => 'Business',
            'slug' => 'business',
        ]);

        \App\Models\Interest::create([
            'name' => 'Photography',
            'slug' => 'photography',
        ]);

        \App\Models\Interest::create([
            'name' => 'Music',
            'slug' => 'music',
        ]);

        \App\Models\Interest::create([
            'name' => 'Writing',
            'slug' => 'writing',
        ]);

        \App\Models\Interest::create([
            'name' => 'Video',
            'slug' => 'video',
        ]);

        \App\Models\Interest::create([
            'name' => 'Education',
            'slug' => 'education',
        ]);

        \App\Models\Interest::create([
            'name' => 'Health',
            'slug' => 'health',
        ]);

        \App\Models\Interest::create([
            'name' => 'Sports',
            'slug' => 'sports',
        ]);

        \App\Models\Interest::create([
            'name' => 'Food',
            'slug' => 'food',
        ]);

        \App\Models\Interest::create([
            'name' => 'Travel',
            'slug' => 'travel',
        ]);

        \App\Models\Interest::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
        ]);

        \App\Models\Interest::create([
            'name' => 'Art',
            'slug' => 'art',
        ]);

        \App\Models\Interest::create([
            'name' => 'Science',
            'slug' => 'science',
        ]);

        \App\Models\Interest::create([
            'name' => 'Technology',
            'slug' => 'technology',
        ]);

        \App\Models\Interest::create([
            'name' => 'Gaming',
            'slug' => 'gaming',
        ]);
    }
}
