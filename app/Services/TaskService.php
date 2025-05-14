<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;

class TaskService
{
    public function list(User $user, array $filters = [])
    {
        $query = Task::with('status');
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }
        if (isset($filters['status_id'])) {
            $query->where('status_id', $filters['status_id']);
        }
        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        return $query->paginate(3);
    }

    public function create(User $user, array $data): Task
    {
        $assignedUserId = $user->isAdmin() && isset($data['user_id'])
            ? $data['user_id']
            : $user->id;
        $data['user_id'] = $assignedUserId;
        $data['status_id'] = 2;
        // dd($data);
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $user = auth()->user();
        $assignedUserId = $user->isAdmin() && isset($data['user_id'])
            ? $data['user_id']
            : $task->user_id;
        $data['user_id'] = $assignedUserId;
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
