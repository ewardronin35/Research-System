<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('dark_mode', false) ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pilar-Research Repository') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('pilarLogo.png') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />
        <x-loading-overlay/>

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Toast Notifications -->
        <script>
            $(document).ready(function() {
                // Configure Toastr first
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": "5000",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "extendedTimeOut": "1000",
                    "newestOnTop": true
                };
                
                // Function to check and show toasts
                function showToasts() {
                    @if(session('status'))
                        toastr.info("{{ session('status') }}");
                    @endif
                    
                    @if(session('success'))
                        toastr.success("{{ session('success') }}");
                    @endif
                    
                    @if(session('error'))
                        toastr.error("{{ session('error') }}");
                    @endif
                    
                    @if(session('warning'))
                        toastr.warning("{{ session('warning') }}");
                    @endif
                    
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            toastr.error("{{ $error }}");
                        @endforeach
                    @endif
                }
                
                // Show loading overlay initially but hide it quickly if we're not navigating
                if (!document.referrer) {
                    hideLoading();
                }
                
                // Show toasts after a short delay to ensure DOM is ready
                setTimeout(function() {
                    showToasts();
                }, 500);
                
                // Hide loading overlay when page is fully loaded
                $(window).on('load', function() {
                    setTimeout(function() {
                        hideLoading();
                        // Show toasts again after loading is complete
                        showToasts(); 
                    }, 300);
                });
                
                // Add loading state to links and form submissions
                $('a:not([href^="#"]):not([target="_blank"]):not(.no-loading)').on('click', function() {
                    showLoading();
                });
                
                $('form:not(.no-loading)').on('submit', function() {
                    showLoading();
                });
                
                // Handle AJAX requests
                $(document).ajaxStart(function() {
                    showLoading();
                });
                
                $(document).ajaxStop(function() {
                    hideLoading();
                });
            });
        </script>

        @stack('modals')
        @livewireScripts
    </body>
</html>