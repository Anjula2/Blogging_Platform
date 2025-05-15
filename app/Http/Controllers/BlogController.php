<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('user')->latest()->paginate(10);
        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::with(['user', 'comments.user', 'likes', 'bookmarks'])
            ->where('slug', $slug)->firstOrFail();

        $user = auth()->user();

        $liked = false;
        $bookmarked = false;

        if ($user) {
            $liked = $post->likes->contains('user_id', $user->id);
            $bookmarked = $post->bookmarks->contains('user_id', $user->id);
        }

        return view('blog.show', compact('post', 'liked', 'bookmarked'));
    }

    public function like($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $message = 'Like removed';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $message = 'Post liked';
        }

        return back()->with('success', $message);
    }

    public function bookmark($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        $bookmark = $post->bookmarks()->where('user_id', $user->id)->first();

        if ($bookmark) {
            $bookmark->delete();
            $message = 'Removed from saved posts';
        } else {
            $post->bookmarks()->create(['user_id' => $user->id]);
            $message = 'Post saved';
        }

        return back()->with('success', $message);
    }

    public function comment(Request $request, $slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'blog_post_id' => $post->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment posted!');
    }

    public function savedPosts()
    {
        $user = auth()->user();
        $bookmarks = $user->bookmarks()->with('blogpost')->paginate(10);
        return view('blog.savedpost', compact('bookmarks'));
    }
}
