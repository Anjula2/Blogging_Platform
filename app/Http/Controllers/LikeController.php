<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class LikeController extends Controller
{
    public function toggle(BlogPost $post)
    {
        $user = auth()->user();
        $user->likes()->toggle($post->id);
        return redirect()->back();
    }
}
