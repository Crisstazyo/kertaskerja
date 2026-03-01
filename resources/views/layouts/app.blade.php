<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kertas Kerja')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .card-disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    {{-- Session Messages --}}
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-50 border border-green-200 text-green-800 px-6 py-3 rounded-lg shadow-md z-50 max-w-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-50 border border-red-200 text-red-800 px-6 py-3 rounded-lg shadow-md z-50 max-w-sm">
        {{ session('error') }}
    </div>
    @endif

    @yield('content')
</body>
</html>
