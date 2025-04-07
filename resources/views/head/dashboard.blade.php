<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                {{ __('Research Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Quick Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Research Papers -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-indigo-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wider">Total Research Papers</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalResearchPapers }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Programs -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-green-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wider">Total Programs</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalPrograms }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-blue-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wider">Total Users</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalUsers }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Research Types -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-purple-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 01-4.186-3.69l-.778-2.334a2 2 0 00-1.904-1.355H5.022a2 2 0 00-1.902 2.59l1.368 4.105a13.366 13.366 0 006.195 7.194l2.877 1.773a2 2 0 002.743-.611l1.845-2.865a2 2 0 00-.27-2.463l-1.628-1.628z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wider">Research Types</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalResearchTypes }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Course Distribution Chart -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 lg:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12H4V4z" />
                            </svg>
                            Course Distribution
                        </h3>
                    </div>
                    <canvas id="courseDistributionChart" class="w-full h-64"></canvas>
                </div>

                <!-- User Table -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            User List
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="userDataTable">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Name</th>
                                    <th scope="col" class="px-4 py-3">Email</th>
                                    <th scope="col" class="px-4 py-3">Role</th>
                                    <th scope="col" class="px-4 py-3">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        @foreach($user->roles as $role)
                                            <span class="px-2 py-1 bg-indigo-500 text-white text-xs rounded-full">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-3">{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Research Insights -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Research Type Distribution -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Research Types
                        </h3>
                    </div>
                    <canvas id="researchTypeChart" class="w-full h-64"></canvas>
                </div>

                <!-- Research Design Distribution -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12H4V4z" />
                            </svg>
                            Research Designs
                        </h3>
                    </div>
                    <canvas id="researchDesignChart" class="w-full h-64"></canvas>
                </div>

                <!-- Recent Research Papers -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Recent Research Papers
                        </h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($recentResearchPapers as $paper)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-300 ease-in-out">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate max-w-[200px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 inline text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ Str::limit($paper->title, 30) }}
                                </h4>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $paper->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-2 mb-2">
                                {{ Str::limit($paper->abstract, 100) }}
                            </p>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    {{ $paper->course }}
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ Str::limit($paper->researchers, 20) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DataTables Initialization
            if ($.fn.DataTable) {
                $('#userDataTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: '_INPUT_',
                        searchPlaceholder: 'Search users...',
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>',
                            next: '<i class="fas fa-angle-right"></i>'
                        },
                        info: 'Showing _START_ to _END_ of _TOTAL_ users',
                        infoEmpty: 'No users available',
                        infoFiltered: '(filtered from _MAX_ total users)',
                        emptyTable: 'No data available in table'
                    },
                    pagingType: 'full_numbers', // This ensures full pagination controls
                    dom: 
                        "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    renderer: 'bootstrap'
                });
            }

            // Consistent Chart Configuration
            const chartConfig = {
                responsive: true,
                maintainAspectRatio: true,
                layout: {
                    padding: 10
                },
                plugins: {
                    legend: { 
                        position: 'top',
                        labels: {
                            boxWidth: 20,
                            usePointStyle: true,
                        }
                    }
                }
            };

            // Course Distribution Chart
            new Chart(document.getElementById('courseDistributionChart'), {
                type: 'pie',
                data: {
                    labels: @json($courseCounts->keys()),
                    datasets: [{
                        data: @json($courseCounts->values()),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)'
                        ]
                    }]
                },
                options: {
                    ...chartConfig,
                    aspectRatio: 1.5,
                    plugins: {
                        ...chartConfig.plugins,
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.formattedValue;
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // Research Type Chart
            new Chart(document.getElementById('researchTypeChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($researchTypeCounts->keys()),
                    datasets: [{
                        data: @json($researchTypeCounts->values()),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)'
                        ]
                    }]
                },
                options: {
                    ...chartConfig,
                    aspectRatio: 1.5,
                    cutout: '50%',
                    plugins: {
                        ...chartConfig.plugins,
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.formattedValue;
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // Research Design Chart
            new Chart(document.getElementById('researchDesignChart'), {
                type: 'bar',
                data: {
                    labels: @json($researchDesignCounts->keys()),
                    datasets: [{
                        label: 'Research Designs',
                        data: @json($researchDesignCounts->values()),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    ...chartConfig,
                    scales: {
                        y: { 
                            beginAtZero: true,
                            min: 0,
                            ticks: {
                                precision: 0,
                                callback: function(value) {
                                    // Ensure whole numbers
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            },
                            grid: {
                                drawBorder: true,
                                color: 'rgba(0,0,0,0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        ...chartConfig.plugins,
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.parsed.y}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>