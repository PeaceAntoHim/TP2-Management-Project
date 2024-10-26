<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects.store', [ProjectController::class, 'store'])->name('projects.store');
Route::post('/projects/search', [ProjectController::class, 'search'])->name('projects.search');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

// Route for displaying the task creation form
Route::resource('projects.tasks', TaskController::class);
Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

Route::post('/projects/{projectId}/tasks', [TaskController::class, 'store'])->name('tasks.store');
