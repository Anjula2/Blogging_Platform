<?php

namespace App\Policies;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogPostPolicy
{
    public function update(User $user, BlogPost $post)
    {
        return $user->hasRole('admin') || ($user->hasRole('editor') && $user->id === $post->user_id);
    }

    public function delete(User $user, BlogPost $post)
    {
        return $user->hasRole('admin') || ($user->hasRole('editor') && $user->id === $post->user_id);
    }
}
