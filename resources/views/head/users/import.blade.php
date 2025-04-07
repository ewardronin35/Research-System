<!-- resources/views/head/users/import.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import Users from CSV') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Instructions</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-2">
                            Upload a CSV file with the following columns:
                        </p>
                        <ul class="list-disc pl-5 text-gray-600 dark:text-gray-400 mb-4">
                            <li><strong>name</strong> - Full name of the user (required)</li>
                            <li><strong>email</strong> - Email address (required, must be unique)</li>
                            <li><strong>role</strong> - User role: admin, head, faculty, or researcher (required)</li>
                            <li><strong>can_login</strong> - Optional: Set to "yes" or "no" (defaults to "yes" if not provided)</li>
                        </ul>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Note: User passwords will be automatically generated. You can reset passwords after import.
                        </p>
                        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Example CSV format:</p>
                            <pre class="text-xs text-gray-600 dark:text-gray-400 overflow-x-auto">name,email,role,can_login
John Doe,john@example.com,researcher,yes
Jane Smith,jane@example.com,faculty,yes
Admin User,admin@example.com,admin,yes</pre>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('head.users.import') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <x-label for="csv_file" :value="__('CSV File')" />
                            <input id="csv_file" type="file" name="csv_file" class="block mt-1 w-full" accept=".csv, text/csv" required />
                            @error('csv_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('head.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mr-2">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Import Users') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>