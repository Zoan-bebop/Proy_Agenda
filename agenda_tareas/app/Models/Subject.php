<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];

    // Relationship: a subject belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: a subject has many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class, 'subject_id');
    }
}