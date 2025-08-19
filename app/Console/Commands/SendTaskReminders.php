<?php

// app/Console/Commands/SendTaskReminders.php
namespace App\Console\Commands;

use App\Models\Task;
use App\Models\TaskNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskReminder;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send reminders for upcoming tasks';

    public function handle()
    {
        $tasks = Task::where('reminder', true)
            ->where('reminder_time', '<=', now())
            ->where('status', '!=', 'executée')
            ->with('user')
            ->get();

        foreach ($tasks as $task) {
            // Envoyer l'email
            Mail::to($task->user->email)->send(new TaskReminder($task));
            
            // Enregistrer la notification
            TaskNotification::create([
                'task_id' => $task->id,
                'user_id' => $task->user_id,
                'message' => "Rappel pour la tâche: {$task->title}",
                'sent_at' => now(),
                'status' => 'envoyée',
            ]);
            
            // Désactiver le rappel pour éviter les répétitions
            $task->update(['reminder' => false]);
        }

        $this->info("{$tasks->count()} rappels envoyés.");
    }
}