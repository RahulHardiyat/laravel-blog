<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomePageController extends Controller
{

    public function index() {

        $newestData = $this->lastData();

        $data = Post::where('status', 'published')->where('id', '!=', $newestData->id)->orderBy('id', 'desc')->paginate(2);

        return view('components.front.home-page', compact('data', 'newestData'));
    }

    private function lastData(){
        $data = Post::where('status', 'published')->orderBy('id', 'desc')->latest()->first();
        return $data;
    }
}
