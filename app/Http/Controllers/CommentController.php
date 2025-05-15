<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Mail\NewCommentNotification;
use Illuminate\Support\Facades\Mail;


class CommentController extends Controller
{
    public function store(Request $request, BlogPost $post)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }

    public function maistore(Request $request, $postId)
{
    $request->validate([
        'body' => 'required|string|max:1000',
    ]);

    $post = BlogPost::findOrFail($postId);

    $comment = $post->comments()->create([
        'user_id' => auth()->id(),
        'body' => $request->body,
    ]);

    if ($post->user->id !== auth()->id()) {
        Mail::to($post->user->email)->send(new NewCommentNotification($comment));
    }

    return redirect()->back()->with('success', 'Comment added!');
}
}
