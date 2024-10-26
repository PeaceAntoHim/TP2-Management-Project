<?php

// app/Http/Controllers/TaskController.php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Show the task creation form
    public function create(Project $project)
    {
        return view('tasks.create', compact('project'));
    }

    // Store the new task
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,in_progress,completed',
            'due_date' => 'nullable|date'
        ]);

        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status = $request->status ?? 'pending';
        $task->due_date = $request->due_date;
        $task->project_id = $project->id;
        $task->save();

        return redirect()->route('projects.index')->with('success', 'Task created successfully!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->status = $request->status;
        $task->save();

        return redirect()->back()->with('success', 'Task status updated successfully.');
    }
}
