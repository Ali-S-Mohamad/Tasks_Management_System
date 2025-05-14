<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    protected static function booted()
    {
        static::deleting(function (Status $status) {
            $trashed = static::firstOrCreate(['name' => 'trashed']);

            $status->tasks()->update([
                'status_id' => $trashed->id,
            ]);
        });
    }
}
