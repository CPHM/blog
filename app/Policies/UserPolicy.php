<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, User $model)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->admin;
    }

    public function update(User $user, User $model)
    {
        return ($user->admin && !$model->admin) || $user->id === $model->id;
    }

    public function delete(User $user, User $model)
    {
        return ($user->admin && !$model->admin) || $user->id === $model->id;
    }

}
