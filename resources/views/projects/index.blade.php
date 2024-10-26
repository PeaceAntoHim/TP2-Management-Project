@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Project List</h1>
            <a href="{{ route('projects.create') }}"
                class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-200">
                + Create Project
            </a>
        </div>

        <form action="{{ route('projects.search') }}" method="POST" class="flex items-center mb-8">
            @csrf
            <form action="{{ route('projects.search') }}" method="POST" class="flex items-center mb-8">
                @csrf
                <input type="text" name="search" placeholder="Search projects..."
                    class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                <input type="date" name="search_date" placeholder="Search by date"
                    class="ml-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Search
                </button>
            </form>

        </form>

        @foreach ($projects as $project)
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-semibold text-blue-600 mb-2">{{ $project->name }}</h2>
                    <a href="{{ route('tasks.create', $project->id) }}"
                        class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200">
                        + Create Task
                    </a>
                </div>
                <p class="text-gray-500 mb-4">Due Date: {{ $project->due_date }}</p>

                <h3 class="text-xl font-bold text-gray-700 mb-2">Tasks</h3>
                <ul class="list-disc list-inside space-y-2">
                    @foreach ($project->tasks as $task)
                        <li class="flex justify-between items-center p-2 bg-gray-50 rounded-lg shadow-sm">
                            <span class="text-gray-800 font-medium">
                                {{ $task->name }} - Due: {{ $task->due_date }}
                            </span>
                            <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST"
                                class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                                <span
                                    class="ml-2 px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $task->status === 'completed'
                                        ? 'bg-green-500 text-white'
                                        : ($task->status === 'in_progress'
                                            ? 'bg-yellow-500 text-gray-800'
                                            : 'bg-gray-300 text-gray-800') }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </form>
                        </li>
                    @endforeach
                </ul>

                <!-- Chart for Project Status -->
                <div class="mt-6">
                    <canvas id="chart-{{ $project->id }}" width="400" height="200"></canvas>
                </div>
                <script>
                    const ctx{{ $project->id }} = document.getElementById('chart-{{ $project->id }}').getContext('2d');
                    const chart{{ $project->id }} = new Chart(ctx{{ $project->id }}, {
                        type: 'bar',
                        data: {
                            labels: ['Pending', 'In Progress', 'Completed'],
                            datasets: [{
                                label: 'Task Status',
                                data: [
                                    {{ $project->tasks->where('status', 'pending')->count() }},
                                    {{ $project->tasks->where('status', 'in_progress')->count() }},
                                    {{ $project->tasks->where('status', 'completed')->count() }}
                                ],
                                backgroundColor: ['#FF6384', '#36A2EB', '#4BC0C0']
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                }
                            }
                        }
                    });
                </script>
            </div>
        @endforeach
    </div>
@endsection
