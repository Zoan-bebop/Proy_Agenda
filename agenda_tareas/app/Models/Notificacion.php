<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'task_id',
        'message',
        'sent_at',
        'status'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}