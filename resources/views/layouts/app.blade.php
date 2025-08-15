<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TNF Portal</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<nav class="p-4 bg-gray-100 flex gap-4">
    <a href="/">Home</a>
    @auth
        <a href="{{ route('projects.index') }}">Projects</a>
        <a href="{{ route('donors.index') }}">Donors</a>
        <a href="{{ route('volunteers.index') }}">Volunteers</a>
        <a href="{{ route('donations.index') }}">Donations</a>
        <a href="{{ route('expenses.index') }}">Expenses</a>
        <a href="{{ route('attendance.index') }}">Attendance</a>
        <a href="{{ route('message_templates.index') }}">Template Messages</a>
        <a href="{{ route('messages.create') }}">Messages</a>
        <a href="{{ route('attendance.my') }}">My Attendance</a>
    @endauth
</nav>
<main class="p-6">
    @yield('content')
    @if ($errors->any())
        <div class="text-red-600 mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</main>
</body>
</html>