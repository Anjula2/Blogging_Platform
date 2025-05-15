<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BlogPost;

class AdminController extends Controller
{
    public function index()
{
    if (auth()->check() && auth()->user()->hasRole('reader')) {
        abort(403, 'Access denied. Readers are not allowed to access the admin dashboard.');
    }

    $users = User::with('roles')->paginate(15);
    $posts = BlogPost::latest()->paginate(15);
    return view('admin.index', compact('users', 'posts'));
}

public function allUsers()
    {
        $users = User::with('roles')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|string']);
    $user->syncRoles([$request->role]);

    return back()->with('success', 'Role updated successfully');
    }

public function deletePost(BlogPost $post)
{
    $post->delete();
    return back()->with('success', 'Post deleted.');
}

}
