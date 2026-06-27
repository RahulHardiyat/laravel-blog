<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->search;

        $data = Post::where('user_id', $user->id)->where(function($query) use ($search) {
            if ($search) {
                $query->where('title', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%');
            }
    } )->orderBy('id', 'desc')->paginate(5)->withQueryString();

        return view('member.blogs.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('member.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240'
        ], [
            'title.required' => 'Title is required.',
            'content.required' => 'Content is required.',
            'thumbnail.mimes' => 'Thumbnail must be a file of type: jpeg, jpg, png.',
            'thumbnail.image' => 'Images max 10MB.'
        ]);

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time().'.'.$image->getClientOriginalName();
            $destinationPath = public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'));
            $image->move($destinationPath, $imageName);
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'thumbnail' => isset($imageName) ? $imageName : null,
            'status' => $request->status,
            'slug' => $this->generateSlug($request->title),
            'user_id' => Auth::user()->id
        ];

        Post::create($data);

        return redirect()->route('member.blogs.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('edit', $post);
        print_r($post);
        $data = $post;
        return view('member.blogs.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        request()->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240'
        ], [
            'title.required' => 'Title is required.',
            'content.required' => 'Content is required.',
            'thumbnail.mimes' => 'Thumbnail must be a file of type: jpeg, jpg, png.',
            'thumbnail.image' => 'Images max 10MB.'
        ]);

        if ($request->hasFile('thumbnail')) {
            if(isset($post->thumbnail) && file_exists(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'))."/".$post->thumbnail)){
                unlink(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'))."/".$post->thumbnail);
            }
            $image = $request->file('thumbnail');
            $imageName = time().'.'.$image->getClientOriginalName();
            $destinationPath = public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'));
            $image->move($destinationPath, $imageName);
        }

        //SIMPAN PERUBAHAN KE DATA
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'thumbnail' => isset($imageName) ? $imageName : $post->thumbnail,
            'status' => $request->status,
            'slug' => $this->generateSlug($request->title, $post->id)
        ];


        //UPDATE DATA BARU
        Post::where('id', $post->id)->update($data);
        //REDIRECT KE HALAMAN DEPAN
        return redirect()->route('member.blogs.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        if(isset($post->thumbnail) && file_exists
            (public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'))."/".$post->thumbnail)){
                unlink(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'))."/".$post->thumbnail);
        }

        Post::where('id', $post->id)->delete();
        return redirect()->route('member.blogs.index')->with('success', 'Post deleted successfully.');
    }

    private function generateSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Lakukan pengecekan selama slug sudah ada di database
        while (Post::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            // Jika ada yang kembar, tambahkan angka urut di belakangnya
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        return $slug;
    }

    public function dummy()
    {

        return view('member.blogs.index', compact('data'));

    }

}
