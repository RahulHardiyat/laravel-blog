<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//testing
Route::get('/test', function () {
    return view('test');
});

Route::get('/', [\App\Http\Controllers\Front\HomePageController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //Route Resource
    Route::resource('/member/blogs', \App\Http\Controllers\Member\BlogController::class)
        ->names([
            'index' => 'member.blogs.index',
            'edit' => 'member.blogs.edit',
            'update' => 'member.blogs.update',
            'create' => 'member.blogs.create',
            'store' => 'member.blogs.store',
            'destroy' => 'member.blogs.destroy',
        ])->parameters([
            'blogs' => 'post'
        ]);
});

require __DIR__.'/auth.php';

Route::get('/{slug}', [\App\Http\Controllers\BlogDetailController::class, 'detail'])->name('blog.detail');


