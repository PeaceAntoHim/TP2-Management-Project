<?php

// app/Http/Controllers/ProjectController.php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Notification;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('tasks')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
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
        $search = $request->get('search');
        $projects = Project::where('name', 'like', "%$search%")->get();
        return view('projects.index', compact('projects'));
    }
}
