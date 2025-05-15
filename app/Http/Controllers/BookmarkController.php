<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class BookmarkController extends Controller
{
    public function toggle(BlogPost $post)
    {
        $user = auth()->user();
        $user->bookmarks()->toggle($post->id);
        return redirect()->back();
    }
}
