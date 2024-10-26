<?php

// app/Http/Controllers/ProjectController.php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('tasks')->get();
        // Fetch upcoming projects and tasks due within 7 days
        $upcomingProjects = Project::where('due_date', '<=', Carbon::now()->addDays(7))->get();
        $upcomingTasks = Task::where('due_date', '<=', Carbon::now()->addDays(7))
            ->where('status', '!=', 'completed') // Only tasks not yet completed
            ->get();

        // Pass data to the view
        return view('projects.index', compact('projects', 'upcomingProjects', 'upcomingTasks'));
    }

    public function create()
    {
        $upcomingProjects = Project::where('due_date', '<=', Carbon::now()->addDays(7))->get();
        $upcomingTasks = Task::where('due_date', '<=', Carbon::now()->addDays(7))
            ->where('status', '!=', 'completed')
            ->get();
        return view('projects.create', compact('upcomingProjects', 'upcomingTasks'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'due_date' => 'required|date']);
        Project::create($request->all());

        Notification::create(['message' => 'New project created: ' . $request->name]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $searchDate = $request->input('search_date');

        // Base query with eager loading for tasks
        $query = Project::with('tasks');

        // Add name-based search if a term is provided
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        // Add date-based search if a date is provided
        if ($searchDate) {
            $query->whereDate('due_date', $searchDate);
        }

        // Fetch filtered projects
        $projects = $query->get();

        // Upcoming notifications
        $upcomingProjects = Project::where('due_date', '<=', Carbon::now()->addDays(7))->get();
        $upcomingTasks = Task::where('due_date', '<=', Carbon::now()->addDays(7))
            ->where('status', '!=', 'completed')
            ->get();

        return view('projects.index', compact('projects', 'upcomingProjects', 'upcomingTasks'));
    }
}
