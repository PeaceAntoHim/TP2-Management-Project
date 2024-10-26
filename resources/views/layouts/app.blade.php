<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Project Management')</title> <!-- Dynamic title with fallback -->

    <!-- Tailwind CSS Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


    <!-- CSRF Token Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Chart.js for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Include JavaScript CSRF token for AJAX requests -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</head>

<body>
    <div class="container mx-auto px-4">
        <!-- Notifications Area -->
        <div id="notifications" class="mb-4 p-4 bg-yellow-100 rounded-lg shadow">
            @foreach (\App\Models\Notification::where('read', false)->get() as $notification)
                <p class="text-yellow-900">{{ $notification->message }}</p>
            @endforeach
        </div>

        <!-- Main Content -->
        @yield('content')
    </div>
</body>

</html>
