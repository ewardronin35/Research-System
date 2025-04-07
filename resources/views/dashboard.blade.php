<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Head of Research Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Overview -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2 bg-white dark:bg-gray-800">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Research Papers</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 dark:text-gray-200">450</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2 bg-white dark:bg-gray-800">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Researchers</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 dark:text-gray-200">875</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2 bg-white dark:bg-gray-800">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Faculty Advisers</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 dark:text-gray-200">42</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2 bg-white dark:bg-gray-800">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Approvals</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 dark:text-gray-200">18</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Research Distribution -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white dark:bg-gray-700">
                            <h6 class="m-0 font-weight-bold text-primary">Research Distribution by Program</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Export Options:</div>
                                    <a class="dropdown-item" href="#">CSV</a>
                                    <a class="dropdown-item" href="#">PDF</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Print Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <!-- Canvas for Chart.js -->
                                <canvas id="researchDistributionChart" style="height: 20rem;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Research Methodology Breakdown -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white dark:bg-gray-700">
                            <h6 class="m-0 font-weight-bold text-primary">Research Methodology</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">View Options:</div>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                    <a class="dropdown-item" href="#">Last 5 Years</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">All Time</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="methodologyPieChart" style="height: 16rem;"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> Qualitative - Phenomenology
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Quantitative - Descriptive
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Case Study
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Submissions and Management Section -->
            <div class="row">
                <!-- Pending Approval Research Table -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                        <div class="card-header py-3 bg-white dark:bg-gray-700">
                            <h6 class="m-0 font-weight-bold text-primary">Pending Research Approval</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pendingResearchTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Researchers</th>
                                            <th>Course</th>
                                            <th>Submitted</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>The Impact of Climate Change on Agricultural Productivity</td>
                                            <td>John Smith, Maria Garcia</td>
                                            <td>STEM</td>
                                            <td>2 days ago</td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <a href="#" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mental Health Among College Students: A Phenomenological Study</td>
                                            <td>David Wilson, Sarah Chen</td>
                                            <td>BSN</td>
                                            <td>3 days ago</td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <a href="#" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Economic Impacts of COVID-19 on Small Businesses</td>
                                            <td>Alex Johnson, Lisa Wang</td>
                                            <td>ABM</td>
                                            <td>1 week ago</td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <a href="#" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Management & System Stats -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                        <div class="card-header py-3 bg-white dark:bg-gray-700">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-primary btn-lg mb-3">
                                    <i class="fas fa-chart-bar me-2"></i> View Statistics
                                </a>
                                <a href="#" class="btn btn-success btn-lg mb-3">
                                    <i class="fas fa-users me-2"></i> Manage Users
                                </a>
                                <a href="#" class="btn btn-info btn-lg mb-3">
                                    <i class="fas fa-cog me-2"></i> System Settings
                                </a>
                                <a href="#" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-file-export me-2"></i> Export Reports
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                        <div class="card-header py-3 bg-white dark:bg-gray-700">
                            <h6 class="m-0 font-weight-bold text-primary">System Activity</h6>
                        </div>
                        <div class="card-body">
                            <div class="activity-feed">
                                <div class="feed-item d-flex mb-3">
                                    <div class="feed-icon bg-info rounded-circle p-2 me-3">
                                        <i class="fas fa-user-plus text-white"></i>
                                    </div>
                                    <div class="feed-content">
                                        <p class="mb-0 text-gray-800 dark:text-gray-200">New user registered</p>
                                        <small class="text-muted">Today, 10:30 AM</small>
                                    </div>
                                </div>
                                <div class="feed-item d-flex mb-3">
                                    <div class="feed-icon bg-success rounded-circle p-2 me-3">
                                        <i class="fas fa-file-upload text-white"></i>
                                    </div>
                                    <div class="feed-content">
                                        <p class="mb-0 text-gray-800 dark:text-gray-200">New research uploaded</p>
                                        <small class="text-muted">Yesterday, 3:45 PM</small>
                                    </div>
                                </div>
                                <div class="feed-item d-flex mb-3">
                                    <div class="feed-icon bg-warning rounded-circle p-2 me-3">
                                        <i class="fas fa-edit text-white"></i>
                                    </div>
                                    <div class="feed-content">
                                        <p class="mb-0 text-gray-800 dark:text-gray-200">System settings updated</p>
                                        <small class="text-muted">Mar 28, 2:15 PM</small>
                                    </div>
                                </div>
                                <div class="feed-item d-flex">
                                    <div class="feed-icon bg-danger rounded-circle p-2 me-3">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                    <div class="feed-content">
                                        <p class="mb-0 text-gray-800 dark:text-gray-200">Server maintenance scheduled</p>
                                        <small class="text-muted">Apr 1, 12:00 AM - 2:00 AM</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap CSS & JS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Styles for Bootstrap + Tailwind Integration -->
    <style>
        /* Card Border Accents */
        .border-left-primary {
            border-left: 0.25rem solid #4e73df;
        }
        .border-left-success {
            border-left: 0.25rem solid #1cc88a;
        }
        .border-left-info {
            border-left: 0.25rem solid #36b9cc;
        }
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e;
        }
        .border-left-danger {
            border-left: 0.25rem solid #e74a3b;
        }

        /* Card styling */
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-clip: border-box;
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
        }

        /* Color utilities */
        .text-primary { color: #4e73df; }
        .text-success { color: #1cc88a; }
        .text-info { color: #36b9cc; }
        .text-warning { color: #f6c23e; }
        .text-danger { color: #e74a3b; }
        
        /* Dark mode compatible table */
        .table {
            color: inherit;
        }
        .dark .table {
            color: #d1d5db;
        }
        .dark .table-bordered {
            border-color: #4b5563;
        }
        .dark .table th, .dark .table td {
            border-color: #4b5563;
        }
        
        /* Feed Item styling */
        .feed-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Bootstrap button overrides for dark mode */
        .dark .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .dark .btn-success {
            background-color: #10b981;
            border-color: #10b981;
        }
        .dark .btn-info {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .dark .btn-secondary {
            background-color: #6b7280;
            border-color: #6b7280;
        }
        
        /* Background colors for dark mode */
        .dark .bg-info {
            background-color: #3b82f6 !important;
        }
        .dark .bg-success {
            background-color: #10b981 !important;
        }
        .dark .bg-warning {
            background-color: #f59e0b !important;
        }
        .dark .bg-danger {
            background-color: #ef4444 !important;
        }
    </style>

    <!-- Chart.js Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Program Distribution Chart (Bar Chart)
            var programCtx = document.getElementById('researchDistributionChart').getContext('2d');
            var programChart = new Chart(programCtx, {
                type: 'bar',
                data: {
                    labels: ['BSN', 'STEM', 'HUMMS', 'ABM', 'BSCS', 'BSIT'],
                    datasets: [{
                        label: 'Research Papers',
                        data: [85, 120, 75, 65, 55, 50],
                        backgroundColor: [
                            'rgba(78, 115, 223, 0.8)',
                            'rgba(28, 200, 138, 0.8)',
                            'rgba(246, 194, 62, 0.8)',
                            'rgba(54, 185, 204, 0.8)',
                            'rgba(231, 74, 59, 0.8)',
                            'rgba(133, 135, 150, 0.8)'
                        ],
                        borderColor: [
                            'rgb(78, 115, 223)',
                            'rgb(28, 200, 138)',
                            'rgb(246, 194, 62)',
                            'rgb(54, 185, 204)',
                            'rgb(231, 74, 59)',
                            'rgb(133, 135, 150)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? 
                                    'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? 
                                    'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? 
                                    'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Methodology Pie Chart
            var methodologyCtx = document.getElementById('methodologyPieChart').getContext('2d');
            var methodologyChart = new Chart(methodologyCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Phenomenology', 'Quantitative', 'Case Study', 'Narrative', 'Multi-Case'],
                    datasets: [{
                        data: [30, 25, 20, 15, 10],
                        backgroundColor: [
                            '#4e73df',
                            '#1cc88a',
                            '#36b9cc',
                            '#f6c23e',
                            '#e74a3b'
                        ],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? 
                                    'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)'
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</x-app-layout>