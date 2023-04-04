<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return $user->type === 'Admin' || $user->type === 'Announcer';
    }

    public function create(User $user)
    {
        return $user->type === 'Admin';
    }

    public function delete(User $user, Category $category)
    {
        return $user->type === 'Admin';
    }
}
