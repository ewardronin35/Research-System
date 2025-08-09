<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Guest Code Management') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        /* Ensures compatibility with your dark mode theme */
        .dark .card, .dark .card-body, .dark .dataTables_wrapper {
            background-color: #1f2937 !important;
            color: #e5e7eb;
        }
        .dark .dataTables_wrapper .dataTables_length,
        .dark .dataTables_wrapper .dataTables_filter,
        .dark .dataTables_wrapper .dataTables_info,
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #e5e7eb !important;
        }
        .dark .form-control, .dark .form-select {
            background-color: #374151;
            color: #e5e7eb;
            border-color: #4b5563;
        }
        .dark .table {
            color: #e5e7eb;
        }
        .dark .table-hover tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-xl">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0 fw-bold">Generated Codes</h4>
                        <form method="POST" action="{{ route('head.codes.generate') }}" class="d-flex align-items-end gap-2">
                            @csrf
                            <div>
                                <label for="code_count" class="form-label mb-1">Number of Codes</label>
                                <input type="number" min="1" max="100" name="code_count" id="code_count" value="10" class="form-control form-control-sm" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Generate</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="codesDataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th class="text-center">Status</th>
                                    <th>Date Created</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function () {
            $('#codesDataTable').DataTable({
                processing: true,
                serverSide: false, // Set to false as we load all data at once
                ajax: "{{ route('head.codes.all') }}",
                columns: [
                    { data: 'code', name: 'code' },
                    { 
                        data: 'is_used', 
                        name: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (data) {
                                return '<span class="badge bg-danger rounded-pill">Used</span>';
                            } else {
                                return '<span class="badge bg-success rounded-pill">Unused</span>';
                            }
                        }
                    },
                    { data: 'created_at_formatted', name: 'date_created' }
                ],
                order: [[ 2, 'desc' ]], // Default sort by date created
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search codes..."
                }
            });
        });
    </script>
</x-app-layout>