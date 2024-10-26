<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'read'];

    public function checkDueDates()
    {
        // Define how many days before the due date to notify (e.g., 3 days)
        $daysBeforeDue = 3;
        $today = Carbon::now();

        // Check for tasks nearing due date
        $tasks = Task::where('due_date', '<=', $today->addDays($daysBeforeDue))
            ->where('status', '!=', 'completed')
            ->get();

        foreach ($tasks as $task) {
            Notification::create([
                'message' => "Task '{$task->name}' is approaching its due date!",
                'read' => false,
            ]);
        }

        // Check for projects nearing due date
        $projects = Project::where('due_date', '<=', $today->addDays($daysBeforeDue))
            ->get();

        foreach ($projects as $project) {
            Notification::create([
                'message' => "Project '{$project->name}' is approaching its due date!",
                'read' => false,
            ]);
        }
    }
}
