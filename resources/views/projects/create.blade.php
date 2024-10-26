@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-lg bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Create New Project</h1>
        <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-600">Project Name</label>
                <input type="text" name="name" id="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter project name" required>
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-gray-600">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter project description"></textarea>
            </div>

            <div class="space-y-2">
                <label for="due_date" class="block text-sm font-medium text-gray-600">Due Date</label>
                <input type="date" name="due_date" id="due_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                    Create Project
                </button>
            </div>
        </form>
    </div>
@endsection
