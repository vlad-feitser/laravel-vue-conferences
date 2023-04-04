<?php

namespace App\Policies;

use App\Models\Lecture;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LecturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->type === 'Announcer';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Lecture $lecture)
    {
        return $user->id === $lecture->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Lecture $lecture)
    {
        return $user->id === $lecture->user_id || $user->type === 'Admin';
    }

    public function favorite(User $user)
    {
        return $user;
    }

    public function unfavorite(User $user)
    {
        return $user;
    }

    public function favorites(User $user)
    {
        return $user;
    }
}
