@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Create Task for Project: {{ $project->name }}</h1>
        <form method="POST" action="{{ route('tasks.store', $project) }}">
            @csrf
            <div class="form-group mb-4">
                <label for="name" class="block text-gray-700">Task Name</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="form-group mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
            </div>

            <div class="form-group mb-4">
                <label for="due_date" class="block text-gray-700">Due Date</label>
                <input type="date" name="due_date" id="due_date"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <div class="form-group mb-4">
                <label for="status" class="block text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white rounded-lg px-4 py-2 hover:bg-blue-700 transition">Create
                Task</button>
        </form>
    </div>
@endsection
