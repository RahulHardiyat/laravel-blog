<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogDetailController extends Controller
{
    public function detail($slug) {
        echo $slug;

        $data = Post::where('status', "=", 'published')
            ->where('slug', $slug)->firstOrFail();

        return view('components.front.detail-blog', compact('data'));
    }
}
