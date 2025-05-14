<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = [
            ['name' => 'User One',   'email' => 'user1@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'User Two',   'email' => 'user2@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'User Three', 'email' => 'user3@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
        ];

        $statusIds = Status::where('name', '!=', 'trashed')->pluck('id')->all();
        $priorities = ['low', 'medium', 'high'];

        foreach ($usersData as $user) {

            $newUser = User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name'     => $user['name'],
                    'password' => $user['password'],
                    'role'     => $user['role'],
                ]
            );


            for ($i = 1; $i <= 3; $i++) {
                Task::create([
                    'user_id'     => $newUser->id,
                    'status_id'   => $statusIds[array_rand($statusIds)],
                    'title'       => "Task {$i} for {$newUser->name}",
                    'description' => "This is task {$i} assigned to {$newUser->name}.",
                    'priority'    => $priorities[array_rand($priorities)],
                ]);
            }
        }
    }
}
