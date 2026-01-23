<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Report Preview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ $reportTitle }}
                        </h3>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download me-2"></i> Download As
                            </button>
                            <ul class="dropdown-menu">
                                {{-- Build download links using the original request parameters --}}
                                @php
                                    // We remove 'preview' and 'format' to build clean download links
                                    $queryParams = http_build_query($request->except(['preview', 'format']));
                                @endphp
                                <li><a class="dropdown-item" href="{{ url('/research-statistics/generate-report') }}?{{ $queryParams }}&format=pdf" target="_blank"><i class="fas fa-file-pdf me-2 text-danger"></i> PDF</a></li>
                                <li><a class="dropdown-item" href="{{ url('/research-statistics/generate-report') }}?{{ $queryParams }}&format=excel" target="_blank"><i class="fas fa-file-excel me-2 text-success"></i> Excel</a></li>
                                <li><a class="dropdown-item" href="{{ url('/research-statistics/generate-report') }}?{{ $queryParams }}&format=csv" target="_blank"><i class="fas fa-file-csv me-2 text-primary"></i> CSV</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    @foreach($request->input('fields', ['title', 'course', 'year']) as $field)
                                        <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($researches as $index => $research)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        @foreach($request->input('fields', ['title', 'course', 'year']) as $field)
                                            <td>{{ $research->{$field} ?? 'N/A' }}</td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($request->input('fields', [])) + 1 }}" class="text-center">No records found for this report.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>