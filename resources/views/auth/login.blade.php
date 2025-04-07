<x-guest-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script>
    $(document).ready(function() {
        // Configure Toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        
        // Display messages from session if they exist
        @if(session('status'))
            toastr.info("{{ session('status') }}");
        @endif
        
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        
        // Handle validation errors
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    });
</script>
    <div class="min-h-screen flex flex-col items-center justify-center bg-cover bg-center relative" 
         style="background-image: url({{ asset('bg.jpg') }});">

        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        
        <!-- Content container -->
        <div class="z-10 w-full max-w-md px-6 py-8">
            <div class="text-center mb-8">
                <!-- Logo container -->
                <div class="mx-auto w-24 h-24 mb-2 rounded-full overflow-hidden bg-white p-2 shadow-lg">
                    <img src="{{ asset('pilarLogo.png') }}" alt="Pilar Logo" class="w-full h-full object-contain">
                </div>
                <h1 class="mt-4 text-3xl font-bold text-white">Research Repository</h1>
                <p class="mt-2 text-gray-300">Sign in to access the full repository</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="px-6 py-8">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 text-center">Account Login</h2>
                    
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        
                        <div>
                            <x-label for="email" value="{{ __('Email Address') }}" class="text-gray-700 dark:text-gray-300" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <x-input id="email" class="block mt-1 w-full pl-10 pr-4 py-3 border-gray-300 dark:border-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-xl shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="your@email.com" />
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 dark:text-gray-300" />
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                                        {{ __('Forgot password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <x-input id="password" class="block mt-1 w-full pl-10 pr-4 py-3 border-gray-300 dark:border-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-xl shadow-sm" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                            </div>
                        </div>
                        
                        <div class="block mt-6">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" class="h-5 w-5 text-indigo-600" />
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        
                        <div class="mt-6">
                            <x-button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition hover:scale-105">
                                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Sign in') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <a href="/" class="inline-flex items-center text-sm text-white hover:text-indigo-300 transition duration-150 ease-in-out">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#loginForm').on('submit', function(e) {
            // Show a loading message when the form is submitted
            toastr.info('Signing in, please wait...');
            
            // Store login attempt info in localStorage
            localStorage.setItem('login_attempted', 'true');
            localStorage.setItem('login_time', new Date().getTime());
            
            // Show loading overlay
            showLoading();
        });
    });
</script>

</x-guest-layout>