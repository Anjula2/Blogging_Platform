<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/login/{provider}', [SocialAuthController::class, 'redirect'])->name('socialite.redirect');
Route::get('/login/{provider}/callback', [SocialAuthController::class, 'callback'])->name('socialite.callback');

Route::get('/', [BlogController::class, 'index'])->name('blog.index');




Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin|editor'])->group(function () {
        Route::resource('blog', BlogController::class)->except(['index', 'show']);
    });

    Route::middleware(['auth', 'block.reader'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });    
        Route::get('/admin/users', [AdminController::class, 'allUsers'])->name('admin.users');
        Route::post('/admin/user/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
        Route::get('/admin/posts', [BlogPostController::class, 'index'])->name('blog.index');
        Route::get('/admin/newpost', [BlogPostController::class, 'create'])->name('blog.create');
        Route::post('/admin/newpost', [BlogPostController::class, 'store'])->name('admin.store');
        Route::get('/posts/{blogPost:slug}', [BlogPostController::class, 'show'])->name('blog.show');
        Route::get('/posts/{blogPost}/edit', [BlogPostController::class, 'edit'])->name('blog.edit')->middleware('auth');

        Route::put('/posts/{blogPost}', [BlogPostController::class, 'update'])->name('blog.update')->middleware('auth');

        Route::delete('/posts/{blogPost}', [BlogPostController::class, 'destroy'])->name('blog.destroy')->middleware('auth');
        
});

Route::middleware(['auth'])->group(function() {
    Route::get('/saved-posts', [BlogController::class, 'savedPosts'])->name('blog.savedpost');
});


Route::middleware('auth')->group(function () {
    Route::post('/blog/{post}/like', [BlogController::class, 'like'])->name('blog.like');
    Route::post('/blog/{post}/bookmark', [BlogController::class, 'bookmark'])->name('blog.bookmark');
    Route::post('/blog/{post}/comment', [BlogController::class, 'comment'])->name('blog.comment');
});
