<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pilar Research Repository') }} - Research Submission</title>

    <link rel="icon" type="image/png" href="{{ asset('pilarLogo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    
    @stack('styles')

    <style>
        body {
            background-image: linear-gradient(to top right, rgba(29, 3, 69, 0.7), rgba(12, 12, 80, 0.7)), url("{{ asset('bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Figtree', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 0;
        }
        .form-container {
            max-width: 900px;
            width: 100%;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-out;
        }
        .card-header {
            background-color: rgba(67, 97, 238, 0.9);
            border-bottom: none;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }
        .form-label {
            font-weight: 500;
        }
        h2 {
            color: white;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.4);
        }
        .text-muted {
            color: #e9ecef !important;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Style adjustments for Select2 to match the theme */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: .375rem !important;
        }
        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
            background-color: #e9ecef;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="text-center mb-4">
            <a href="{{ url('/') }}">
                <img src="{{ asset('pilarLogo.png') }}" alt="Logo" width="80" style="filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));">
            </a>
            <h2 class="mt-3">{{ config('app.name', 'Pilar Research Repository') }}</h2>
            <p class="text-muted">Guest Research Submission Portal</p>
        </div>
        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    @stack('scripts')
</body>
</html>