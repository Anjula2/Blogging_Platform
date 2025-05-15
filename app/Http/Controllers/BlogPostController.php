<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query()->with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tag')) {
            $tag = $request->tag;
            $query->where('tags', 'like', "%{$tag}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('author')) {
            $author = $request->author;
            $query->whereHas('user', function($q) use ($author) {
                $q->where('name', 'like', "%{$author}%");
            });
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return view('blog.index', compact('posts'));
    }

    public function create()
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403);
        }

        return view('blog.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $data['user_id'] = Auth::id();
        $post = BlogPost::create($data);

        return redirect()->route('blog.index')->with('success', 'Post created successfully!');
    }

    public function show(BlogPost $blogPost)
    {
        $post = $blogPost->load(['user', 'comments.user', 'likes', 'bookmarks']);
        $allPosts = BlogPost::with('user')->latest()->take(5)->get();
        return view('blog.show', compact('post', 'allPosts'));
    }

    public function edit(BlogPost $blogPost)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403);
        }

        if (Auth::id() !== $blogPost->user_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        return view('blog.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403);
        }

        if (Auth::id() !== $blogPost->user_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $blogPost->update($data);

        return redirect()->route('blog.index', $blogPost->id)->with('success', 'Post updated successfully!');
    }

    public function destroy(BlogPost $blogPost)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403);
        }

        if (Auth::id() !== $blogPost->user_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $blogPost->delete();

        return redirect()->route('blog.index')->with('success', 'Post deleted successfully!');
    }
}
