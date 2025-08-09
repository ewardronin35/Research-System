<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Research Approval Management') }}
        </h2>
    </x-slot>

    {{-- CSS Dependencies --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    {{-- Dark Mode Compatibility Styles --}}
    <style>
        .dark .card, .dark .card-body, .dark .nav-tabs .nav-link {
            background-color: #1f2937 !important;
            color: #e5e7eb;
        }
        .dark .dataTables_wrapper .dataTables_length,
        .dark .dataTables_wrapper .dataTables_filter,
        .dark .dataTables_wrapper .dataTables_info,
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #e5e7eb !important;
        }
        .dark .form-control {
            background-color: #374151;
            color: #e5e7eb;
            border-color: #4b5563;
        }
        .dark .table { color: #e5e7eb; }
        .dark .table-hover tbody tr:hover { background-color: rgba(59, 130, 246, 0.1) !important; }
        .dark .nav-tabs { border-bottom-color: #4b5563; }
        .dark .nav-tabs .nav-link.active { background-color: #374151 !important; border-color: #4b5563; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-xl">
                <div class="card-body p-4">

                    {{-- Bootstrap Tab Navigation --}}
                    <ul class="nav nav-tabs mb-4" id="approvalTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                                <i class="fas fa-clock me-2"></i>Pending
                                <span class="badge bg-warning text-dark ms-1">{{ $pendingResearch->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                                <i class="fas fa-check-double me-2"></i>Approved
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">
                                <i class="fas fa-times-circle me-2"></i>Rejected
                            </button>
                        </li>
                    </ul>

                    {{-- Bootstrap Tab Content --}}
                    <div class="tab-content" id="approvalTabsContent">

                        {{-- Pending Tab Pane --}}
                        <div class="tab-pane fade show active" id="pending" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="pendingTable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Course</th>
                                            <th>Researchers</th>
                                            <th>Date Submitted</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pendingResearch as $paper)
                                            <tr>
                                                <td>{{ Str::limit($paper->title, 40) }}</td>
                                                <td>{{ $paper->course }}</td>
                                                <td>{{ Str::limit($paper->researchers, 30) }}</td>
                                                <td>{{ $paper->created_at->format('M d, Y') }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <form action="{{ route('user.research.approve', $paper) }}" method="POST" class="d-inline approval-form">@csrf @method('PATCH')<button type="submit" class="btn btn-success btn-sm" title="Approve"><i class="fas fa-check"></i></button></form>
                                                        <form action="{{ route('user.research.reject', $paper) }}" method="POST" class="d-inline rejection-form">@csrf @method('PATCH')<button type="submit" class="btn btn-danger btn-sm" title="Reject"><i class="fas fa-times"></i></button></form>
                                                        <a href="{{ Storage::url($paper->file_path) }}" target="_blank" class="btn btn-info btn-sm" title="View PDF"><i class="fas fa-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted py-4">No pending research papers.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Approved Tab Pane --}}
                        <div class="tab-pane fade" id="approved" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="approvedTable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Course</th>
                                            <th>Researchers</th>
                                            <th>Date Approved</th>
                                            <th class="text-center">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($approvedResearch as $paper)
                                            <tr>
                                                <td>{{ Str::limit($paper->title, 40) }}</td>
                                                <td>{{ $paper->course }}</td>
                                                <td>{{ Str::limit($paper->researchers, 30) }}</td>
                                                <td>{{ $paper->updated_at->format('M d, Y') }}</td>
                                                <td class="text-center"><a href="{{ Storage::url($paper->file_path) }}" target="_blank" class="btn btn-info btn-sm" title="View PDF"><i class="fas fa-eye"></i></a></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">No approved research papers.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Rejected Tab Pane --}}
                        <div class="tab-pane fade" id="rejected" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="rejectedTable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Course</th>
                                            <th>Researchers</th>
                                            <th>Date Rejected</th>
                                            <th class="text-center">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rejectedResearch as $paper)
                                            <tr>
                                                <td>{{ Str::limit($paper->title, 40) }}</td>
                                                <td>{{ $paper->course }}</td>
                                                <td>{{ Str::limit($paper->researchers, 30) }}</td>
                                                <td>{{ $paper->updated_at->format('M d, Y') }}</td>
                                                <td class="text-center"><a href="{{ Storage::url($paper->file_path) }}" target="_blank" class="btn btn-info btn-sm" title="View PDF"><i class="fas fa-eye"></i></a></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted py-4">No rejected research papers.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript Dependencies --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Custom Scripts --}}
    <script>
        $(function () {
            // Helper function to initialize a DataTable, avoiding re-initialization
            const initDataTable = (tableId) => {
                if ($.fn.DataTable.isDataTable(tableId)) {
                    // If it exists, redraw it to ensure it's up-to-date
                    $(tableId).DataTable().draw();
                    return;
                }
                $(tableId).DataTable({
                    responsive: true,
                    order: [[3, 'desc']],
                    columnDefs: [{ orderable: false, targets: -1 }]
                });
            };

            // Initialize the first visible table on page load
            initDataTable('#pendingTable');

            // Use Bootstrap's tab-shown event to initialize other tables only when they become visible
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                const targetTab = $(e.target).attr('data-bs-target');
                if (targetTab === '#approved') {
                    initDataTable('#approvedTable');
                } else if (targetTab === '#rejected') {
                    initDataTable('#rejectedTable');
                }
            });

            // SweetAlert2 confirmation for approval/rejection forms
            $('form.approval-form, form.rejection-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const action = $(form).hasClass('approval-form') ? 'approve' : 'reject';

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you really want to ${action} this research paper?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: action === 'approve' ? '#198754' : '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: `Yes, ${action} it!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Display success messages from session as a toast notification
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif
        });
    </script>
</x-app-layout>