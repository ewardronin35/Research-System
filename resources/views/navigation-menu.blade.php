<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="{{ asset('pilarLogo.png') }}" class="block h-10 w-auto transition-transform duration-300 hover:scale-110" alt="Logo" />
                        <span class="ml-3 text-lg font-semibold text-gray-800 dark:text-gray-200 hidden md:block">Pilar Research</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 md:space-x-6 sm:-my-px sm:ml-8 sm:flex">
                    <!-- Dashboard Link -->
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" 
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-colors duration-200" 
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2L2 8h3v8h4V12h2v4h4V8h3L10 2z" />
                        </svg>
                        <span>{{ __('Dashboard') }}</span>
                    </x-nav-link>

                    <!-- Research Management Link -->
                    <x-nav-link href="{{ route(request()->segment(1) === 'head' || request()->segment(1) === 'admin' ? 'head.research.index' : 'user.research.index') }}" 
                        :active="request()->routeIs('*.research.index')"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-colors duration-200" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>{{ __('Research') }}</span>
                    </x-nav-link>
                    
                    <!-- Reports Link (Only for head/admin routes) -->
           
                    <x-nav-link href="{{ route('head.statistics.index') }}" :active="request()->routeIs('head.reports.*')" 
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-colors duration-200" 
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" 
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm1 0v12h12V3H4zm3 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm3 0a1 1 0 10-2 0v6a1 1 0 102 0V7zm3 0a1 1 0 10-2 0v8a1 1 0 102 0V7z" 
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ __('Reports') }}</span>
                    </x-nav-link>
              

                    <!-- User Management (Only for head/admin routes) -->
                    @if(request()->segment(1) === 'head' || request()->segment(1) === 'admin')
                    <x-nav-link href="{{ route('head.users.index') }}" :active="request()->routeIs('head.users.*')" 
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-colors duration-200" 
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        <span>{{ __('Manage Users') }}</span>
                    </x-nav-link>
                  
                    @endif
                    @if(request()->segment(1) === 'head' || request()->segment(1) === 'admin')
                      <x-nav-link href="{{ route('head.codes.index') }}" :active="request()->routeIs('head.codes.*')" 
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-colors duration-200" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.257 3.099c.366-.446.957-.533 1.403-.167.446.366.533.957.167 1.403L6.414 8l3.413 3.665c.366.446.279 1.037-.167 1.403-.446.366-1.037.279-1.403-.167l-4-5a1 1 0 010-1.272l4-5zM11.743 16.901c-.366.446-.957.533-1.403.167-.446-.366-.533-.957-.167-1.403L13.586 12l-3.413-3.665c-.366-.446-.279-1.037.167-1.403.446-.366 1.037-.279 1.403.167l4 5a1 1 0 010 1.272l-4 5z"/>
                        </svg>
                        <span>{{ __('Codes') }}</span>
                    </x-nav-link>
                    @else
                      <x-nav-link href="{{ route('user.codes.index') }}" :active="request()->routeIs('user.codes.*')" 
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-colors duration-200" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.257 3.099c.366-.446.957-.533 1.403-.167.446.366.533.957.167 1.403L6.414 8l3.413 3.665c.366.446.279 1.037-.167 1.403-.446.366-1.037.279-1.403-.167l-4-5a1 1 0 010-1.272l4-5zM11.743 16.901c-.366.446-.957.533-1.403.167-.446-.366-.533-.957-.167-1.403L13.586 12l-3.413-3.665c-.366-.446-.279-1.037.167-1.403.446-.366 1.037-.279 1.403.167l4 5a1 1 0 010 1.272l-4 5z"/>
                        </svg>
                        <span>{{ __('Codes') }}</span>
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Theme Switcher -->
                <button 
                    class="flex items-center p-2 mr-3 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 ease-in-out" 
                    @click="document.body.classList.toggle('dark'); $dispatch('dark-mode-toggled')">
                    <template x-if="!document.body.classList.contains('dark')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </template>
                    <template x-if="document.body.classList.contains('dark')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </template>
                </button>

                <!-- Settings Dropdown -->
                <div class="ml-3 relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                    <div>
                        <button @click="open = !open" 
                            class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition-all duration-200 ease-in-out">
                            <div class="flex flex-col items-end">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @if(request()->segment(1) === 'head' || request()->segment(1) === 'admin')
                                        Administrator
                                    @else
                                        Researcher
                                    @endif
                                </div>
                            </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4 transition-transform duration-200" 
                                    :class="{'rotate-180': open, 'rotate-0': !open}" 
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </div>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0"
                         style="display: none;">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-gray-700">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <a href="{{ route('profile.show') }}" 
                                class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profile') }}
                            </a>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <a href="{{ route('api-tokens.index') }}" 
                                    class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    {{ __('API Tokens') }}
                                </a>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a href="{{ route('logout') }}" 
                                    class="flex items-center w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                                   @click.prevent="$root.submit();">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" 
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" 
                class="flex items-center transition-colors duration-200 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2L2 8h3v8h4V12h2v4h4V8h3L10 2z" />
                </svg>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <!-- Research dropdown for mobile -->
            <div @click.away="open = false" class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                    class="w-full flex items-center px-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>{{ __('Research') }}</span>
                    <svg class="ml-auto -mr-0.5 h-4 w-4 transform transition-transform duration-200" 
                        :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="block pl-4 pr-2 py-2 bg-gray-50 dark:bg-gray-800"
                     style="display: none;">
                    <a href="{{ route('user.research.index') }}" 
                        class="block pl-8 pr-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                        {{ __('Browse Research List') }}
                    </a>
                    
                    <a href="{{ route('user.research.create') }}" 
                        class="block pl-8 pr-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                        {{ __('Add New Research') }}
                    </a>
                    
                    <a href="{{ route('user.research.browse') }}" 
                        class="block pl-8 pr-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                        {{ __('Browse Repository') }}
                    </a>
                    
                    <!-- Admin/Head routes are only shown if the URL contains 'head' or 'admin' -->
                    @if(request()->segment(1) === 'head' || request()->segment(1) === 'admin')
                        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                        <a href="{{ route('head.research.all') }}" 
                            class="block pl-8 pr-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                            {{ __('All Research Papers') }}
                        </a>
                        <a href="{{ route('head.research.pending') }}" 
                            class="block pl-8 pr-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                            {{ __('Pending Approvals') }}
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Admin specific links for mobile -->
            @if(request()->segment(1) === 'head' || request()->segment(1) === 'admin')
                <x-responsive-nav-link href="{{ route('head.reports.index') }}" :active="request()->routeIs('head.reports.*')" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm1 0v12h12V3H4zm3 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm3 0a1 1 0 10-2 0v6a1 1 0 102 0V7zm3 0a1 1 0 10-2 0v8a1 1 0 102 0V7z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Reports') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('head.users.index') }}" :active="request()->routeIs('head.users.*')" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    {{ __('Manage Users') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">
                        @if(request()->segment(1) === 'head' || request()->segment(1) === 'admin')
                            Administrator
                        @else
                            Researcher
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" 
                    class="flex items-center transition-colors duration-200 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')" 
                        class="flex items-center transition-colors duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif
                
                <!-- Access role toggles -->
                
                <!-- Authentication -->
                <div class="border-t border-gray-200 dark:border-gray-600 pt-2">
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link href="{{ route('logout') }}" 
                            class="flex items-center transition-colors duration-200 ease-in-out"
                            @click.prevent="$root.submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>