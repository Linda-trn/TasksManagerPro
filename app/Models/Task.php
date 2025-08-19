<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;




class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'due_date', 'due_time',
        'status', 'reminder', 'reminder_time'
    ];

    protected $casts = [
        'due_date' => 'date',
        'reminder' => 'boolean',
        'reminder_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notifications()
    {
        return $this->hasMany(TaskNotification::class);
    }

    // Méthodes utilitaires
    public function isOverdue()
    {
        return now() > $this->due_date->setTimeFromTimeString($this->due_time ?? '23:59:59');
    }

    public function getFullDueDateTimeAttribute()
    {
        return $this->due_date->format('Y-m-d') . ' ' . ($this->due_time ?? '23:59:59');
    }
}

