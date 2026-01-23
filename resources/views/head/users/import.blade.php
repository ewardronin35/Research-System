<x-app-layout>
    {{-- Add FilePond styles to the header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import Users from CSV') }}
        </h2>
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
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

                    @if(session('import_errors') && count(session('import_errors')) > 0)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                            <p class="font-bold">The following rows could not be imported:</p>
                            <ul class="list-disc pl-5 mt-2">
                                @foreach(session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
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
                        <div class="mb-4">
                            <a href="data:text/csv;charset=utf-8,name,email,role,can_login%0AJohn Doe,john@example.com,researcher,yes%0AJane Smith,jane@example.com,faculty,yes"
                               download="sample-users.csv"
                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Sample CSV
                            </a>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('head.users.import') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- The input is now simpler, FilePond will enhance it --}}
                        <div class="mt-4">
                            <x-label for="csv_file" :value="__('CSV File')" />
                            <input id="csv_file" type="file" name="csv_file" required />
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

   <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        // Get a reference to the file input element
        const inputElement = document.querySelector('input[id="csv_file"]');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            name: 'csv_file', 
            storeAsFile: true, 
            labelIdle: `Drag & Drop your CSV file or <span class="filepond--label-action">Browse</span>`,
            acceptedFileTypes: ['text/csv', '.csv', 'application/vnd.ms-excel'],
            labelFileTypeNotAllowed: 'Invalid file type, please upload a CSV',
        });
    </script>
</x-app-layout>