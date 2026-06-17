<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $judul = [
            'Judul post 1'
        ];

        foreach ($judul as $j) {
            $slug = Str::slug($j);
            $slug_base = $slug;
            $count = 1;
            while(Post::where('slug', $slug)->exists()) {
                $slug = $slug_base . '-' . $count;
                $count++;
            }
            echo ($slug);

            Post::create([
                'title' => $j,
                'slug' => $slug,
                'description' => 'deskripsi untuk'. $j,
                'content' => 'content untuk '. $j,
                'status' => 'published',
                'user_id' => 1,
            ]);
        }
    }
}
