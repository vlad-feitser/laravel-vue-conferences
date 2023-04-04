<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user;
    }


    public function create(User $user)
    {
        return $user;
    }


    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
