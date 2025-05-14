<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{

    /**
     * Summary of before
     * @param \App\Models\User $user
     * @param mixed $ability
     * @return bool
     */
    public function before(User $user, $ability): bool|null
    {
        return $user->isAdmin() ? true : null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return auth()->user()->id === $user->id
            ? Response::allow()
            : Response::deny('You are not authorized to view these tasks.');
        ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task)
    {
        return $task->user_id === $user->id
            ? Response::allow()
            : Response::deny('You are not allowed to view this task.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        if (!Status::query()->exists()) {
            return Response::deny('Cannot create a task without any statuses available.');
        }
        return auth()->user()->id === $user->id
            ? Response::allow()
            : Response::deny('You are not allowed to create tasks for other users.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task)
    {
        return $task->user_id === $user->id
            ? Response::allow()
            : Response::deny('You are not allowed to update this task.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task)
    {
        return $task->user_id === $user->id
            ? Response::allow()
            : Response::deny('You are not allowed to delete this task.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task)
    {
        return Response::deny('Restoring tasks is not allowed.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task)
    {
        return Response::deny('Permanently deleting tasks is not permitted.');
    }
}
