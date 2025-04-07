

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Research Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tab Navigation -->
            <div class="mb-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-0">
                        <ul class="nav nav-tabs" id="statsTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                                    <i class="fas fa-chart-pie me-2"></i> Overview
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="visualization-tab" data-bs-toggle="tab" data-bs-target="#visualization" type="button" role="tab" aria-controls="visualization" aria-selected="false">
                                    <i class="fas fa-chart-bar me-2"></i> Visualizations
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button" role="tab" aria-controls="reports" aria-selected="false">
                                    <i class="fas fa-file-alt me-2"></i> Reports
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="statsTabContent">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <!-- Generate Report Button -->
                    <div class="mb-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Research Statistics Overview</h3>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-file-export me-2"></i> Generate Report
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" id="generateFullReport"><i class="fas fa-file-pdf me-2"></i> Complete Report</a></li>
                                        <li><a class="dropdown-item" href="#" id="generateCourseReport"><i class="fas fa-file-chart-column me-2"></i> Course Statistics</a></li>
                                        <li><a class="dropdown-item" href="#" id="generateYearReport"><i class="fas fa-calendar-alt me-2"></i> Yearly Trends</a></li>
                                        <li><a class="dropdown-item" href="#" id="generateDesignReport"><i class="fas fa-flask me-2"></i> Research Design Analysis</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#" id="customReportBtn"><i class="fas fa-sliders me-2"></i> Custom Report</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Key Metrics Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2 bg-white dark:bg-gray-800">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Research Papers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 dark:text-gray-200">{{ $stats['totalPapers'] }}</div>
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
                                                This Year's Papers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 dark:text-gray-200">{{ $stats['publishedThisYear'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                                Total Researchers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 dark:text-gray-200">{{ $stats['totalResearchers'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                                Faculty Advisers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 dark:text-gray-200">{{ $stats['totalAdvisers'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Research Data Table -->
                    <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                        <div class="card-header py-3 bg-white dark:bg-gray-700">
                            <h6 class="m-0 font-weight-bold text-primary">Research Papers Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="researchTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Course</th>
                                            <th>Year</th>
                                            <th>Research Design</th>
                                            <th>Category</th>
                                            <th>Researchers</th>
                                            <th>Adviser</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($researches as $research)
                                        <tr>
                                            <td>{{ $research->title }}</td>
                                            <td>{{ $research->course }}</td>
                                            <td>{{ $research->year }}</td>
                                            <td>{{ $research->research_design ?? 'Not Specified' }}</td>
                                            <td>{{ $research->category ?? 'Not Specified' }}</td>
                                            <td>{{ $research->researchers }}</td>
                                            <td>{{ $research->adviser }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visualizations Tab -->
                <div class="tab-pane fade" id="visualization" role="tabpanel" aria-labelledby="visualization-tab">
                    <!-- Controls for visualizations -->
                    <div class="mb-4">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Data Visualizations</h3>
                                <div class="mt-2 mt-md-0">
                                    <div class="btn-group me-2">
                                        <button type="button" class="btn btn-outline-primary" id="downloadAllCharts">
                                            <i class="fas fa-download me-1"></i> Export All Charts
                                        </button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-secondary" id="refreshCharts">
                                            <i class="fas fa-sync-alt me-1"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Row -->
                    <div class="row mb-4">
                        <!-- Research by Course Chart -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white dark:bg-gray-700">
                                    <h6 class="m-0 font-weight-bold text-primary">Research Papers by Course</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="courseDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="courseDropdown">
                                            <div class="dropdown-header">Chart Options:</div>
                                            <a class="dropdown-item course-chart-type" data-type="bar" href="#">Bar Chart</a>
                                            <a class="dropdown-item course-chart-type" data-type="pie" href="#">Pie Chart</a>
                                            <a class="dropdown-item course-chart-type" data-type="doughnut" href="#">Doughnut Chart</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ url('/research-statistics/generate-report') }}?{{ http_build_query(['type' => 'course']) }}">Export Data</a>
                                            <a class="dropdown-item download-chart" data-chart="courseChart" href="#">Download Chart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="courseChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Research by Year Chart -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white dark:bg-gray-700">
                                    <h6 class="m-0 font-weight-bold text-primary">Research Papers by Year</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="yearDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="yearDropdown">
                                            <div class="dropdown-header">Chart Options:</div>
                                            <a class="dropdown-item year-chart-type" data-type="line" href="#">Line Chart</a>
                                            <a class="dropdown-item year-chart-type" data-type="bar" href="#">Bar Chart</a>
                                            <a class="dropdown-item year-chart-type" data-type="area" href="#">Area Chart</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ url('/research-statistics/generate-report') }}?{{ http_build_query(['type' => 'year']) }}">Export Data</a>
                                            <a class="dropdown-item download-chart" data-chart="yearChart" href="#">Download Chart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="yearChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Chart Row -->
                    <div class="row mb-4">
                        <!-- Research by Methodology Chart -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white dark:bg-gray-700">
                                    <h6 class="m-0 font-weight-bold text-primary">Research by Methodology</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="methodologyDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="methodologyDropdown">
                                            <div class="dropdown-header">Chart Options:</div>
                                            <a class="dropdown-item methodology-chart-type" data-type="bar" href="#">Bar Chart</a>
                                            <a class="dropdown-item methodology-chart-type" data-type="pie" href="#">Pie Chart</a>
                                            <a class="dropdown-item methodology-chart-type" data-type="doughnut" href="#">Doughnut Chart</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ url('/research-statistics/generate-report') }}?{{ http_build_query(['type' => 'methodology']) }}">Export Data</a>
                                            <a class="dropdown-item download-chart" data-chart="methodologyChart" href="#">Download Chart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="methodologyChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Research by Category Chart -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white dark:bg-gray-700">
                                    <h6 class="m-0 font-weight-bold text-primary">Research by Category</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="categoryDropdown">
                                            <div class="dropdown-header">Chart Options:</div>
                                            <a class="dropdown-item category-chart-type" data-type="bar" href="#">Bar Chart</a>
                                            <a class="dropdown-item category-chart-type" data-type="pie" href="#">Pie Chart</a>
                                            <a class="dropdown-item category-chart-type" data-type="doughnut" href="#">Doughnut Chart</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ url('/research-statistics/generate-report') }}?{{ http_build_query(['type' => 'category']) }}">Export Data</a>
                                            <a class="dropdown-item download-chart" data-chart="categoryChart" href="#">Download Chart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="categoryChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Charts Row -->
                    <div class="row mb-4">
                        <!-- Course vs Year Heatmap -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white dark:bg-gray-700">
                                    <h6 class="m-0 font-weight-bold text-primary">Course by Year Heatmap</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="heatmapDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="heatmapDropdown">
                                            <div class="dropdown-header">Chart Options:</div>
                                            <a class="dropdown-item" href="#" id="reverseHeatmapColors">Reverse Colors</a>
                                            <a class="dropdown-item" href="#" id="normalizeHeatmap">Normalize Data</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item download-chart" data-chart="heatmapChart" href="#">Download Chart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="heatmapChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trend Analysis -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white dark:bg-gray-700">
                                    <h6 class="m-0 font-weight-bold text-primary">Research Trend Analysis</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="trendDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="trendDropdown">
                                            <div class="dropdown-header">Chart Options:</div>
                                            <a class="dropdown-item" href="#" id="showTrendline">Show/Hide Trendline</a>
                                            <a class="dropdown-item" href="#" id="toggleCumulative">Toggle Cumulative</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item download-chart" data-chart="trendChart" href="#">Download Chart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="trendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports Tab -->
                <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                    <!-- Custom Report Generator -->
                    <div class="card shadow mb-4 bg-white dark:bg-gray-800">
                        <div class="card-header py-3 bg-white dark:bg-gray-700">
                            <h6 class="m-0 font-weight-bold text-primary">Custom Report Generator</h6>
                        </div>
                        <div class="card-body">
                        <form id="customReportForm" action="{{ url('/research-statistics/generate-report') }}" method="GET">
                        <div class="mb-3">
                                    <label for="reportName" class="form-label">Report Name</label>
                                    <input type="text" class="form-control" id="reportName" name="report_name" value="Custom Research Report">
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Course Filter</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="allCourses" checked>
                                            <label class="form-check-label" for="allCourses">All Courses</label>
                                        </div>
                                        <div id="courseCheckboxes">
                                            @foreach($courseData as $course)
                                            <div class="form-check">
                                                <input class="form-check-input course-checkbox" type="checkbox" name="course[]" value="{{ $course->course }}" id="course{{ $loop->index }}" disabled>
                                                <label class="form-check-label" for="course{{ $loop->index }}">
                                                    {{ $course->course }} ({{ $course->count }})
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Year Range</label>
                                        <div class="row g-3">
                                            <div class="col">
                                                <label for="yearStart" class="form-label">From</label>
                                                <select class="form-select" id="yearStart" name="year_start">
                                                    <option value="">Any</option>
                                                    @foreach($yearData as $year)
                                                    <option value="{{ $year->year }}">{{ $year->year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="yearEnd" class="form-label">To</label>
                                                <select class="form-select" id="yearEnd" name="year_end">
                                                    <option value="">Any</option>
                                                    @foreach($yearData as $year)
                                                    <option value="{{ $year->year }}">{{ $year->year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Research Design</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="allDesigns" checked>
                                            <label class="form-check-label" for="allDesigns">All Research Designs</label>
                                        </div>
                                        <div id="designCheckboxes">
                                            @foreach($methodologyData as $method)
                                            <div class="form-check">
                                                <input class="form-check-input design-checkbox" type="checkbox" name="research_design[]" value="{{ $method->research_design }}" id="design{{ $loop->index }}" disabled>
                                                <label class="form-check-label" for="design{{ $loop->index }}">
                                                    {{ $method->research_design ?? 'Not Specified' }} ({{ $method->count }})
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Category</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="allCategories" checked>
                                            <label class="form-check-label" for="allCategories">All Categories</label>
                                        </div>
                                        <div id="categoryCheckboxes">
                                            @foreach($categoryData as $category)
                                            <div class="form-check">
                                                <input class="form-check-input category-checkbox" type="checkbox" name="category[]" value="{{ $category->category }}" id="category{{ $loop->index }}" disabled>
                                                <label class="form-check-label" for="category{{ $loop->index }}">
                                                    {{ $category->category ?? 'Not Specified' }} ({{ $category->count }})
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Fields to Include</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="title" id="fieldTitle" checked>
                                                <label class="form-check-label" for="fieldTitle">Title</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="course" id="fieldCourse" checked>
                                                <label class="form-check-label" for="fieldCourse">Course</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="researchers" id="fieldResearchers" checked>
                                                <label class="form-check-label" for="fieldResearchers">Researchers</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="adviser" id="fieldAdviser" checked>
                                                <label class="form-check-label" for="fieldAdviser">Adviser</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="year" id="fieldYear" checked>
                                                <label class="form-check-label" for="fieldYear">Year</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="research_design" id="fieldDesign">
                                                <label class="form-check-label" for="fieldDesign">Research Design</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="category" id="fieldCategory">
                                                <label class="form-check-label" for="fieldCategory">Category</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="program" id="fieldProgram">
                                                <label class="form-check-label" for="fieldProgram">Program</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[]" value="abstract" id="fieldAbstract">
                                                <label class="form-check-label" for="fieldAbstract">Abstract</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Report Format</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="format" id="formatPdf" value="pdf" checked>
                                            <label class="form-check-label" for="formatPdf">
                                                <i class="fas fa-file-pdf text-danger me-1"></i> PDF
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="format" id="formatExcel" value="excel">
                                            <label class="form-check-label" for="formatExcel">
                                                <i class="fas fa-file-excel text-success me-1"></i> Excel
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="format" id="formatCsv" value="csv">
                                            <label class="form-check-label" for="formatCsv">
                                                <i class="fas fa-file-csv text-primary me-1"></i> CSV
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 text-end">
                                    <button type="button" id="clearFormBtn" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-eraser me-1"></i> Clear Form
                                    </button>
                                    <button type="submit" id="generateCustomReport" class="btn btn-primary">
                                        <i class="fas fa-file-export me-1"></i> Generate Report
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Pre-defined Reports -->
                    <div class="card shadow mb-4 bg-white dark:bg-gray-800">
    <div class="card-header py-3 bg-white dark:bg-gray-700">
        <h6 class="m-0 font-weight-bold text-primary">Pre-defined Reports</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-file-alt text-primary me-2"></i> Complete Report
                        </h5>
                        <p class="card-text">Comprehensive report of all research papers with complete details.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <div class="btn-group report-btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Generate
                            </button>
                            <ul class="dropdown-menu report-dropdown">
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=all&format=pdf"><i class="fas fa-file-pdf me-2"></i> PDF</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=all&format=excel"><i class="fas fa-file-excel me-2"></i> Excel</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=all&format=csv"><i class="fas fa-file-csv me-2"></i> CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-chart-bar text-success me-2"></i> Course Statistics
                        </h5>
                        <p class="card-text">Research papers distribution by course with detailed analysis.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <div class="btn-group report-btn-group">
                            <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Generate
                            </button>
                            <ul class="dropdown-menu report-dropdown">
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=course&format=pdf"><i class="fas fa-file-pdf me-2"></i> PDF</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=course&format=excel"><i class="fas fa-file-excel me-2"></i> Excel</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=course&format=csv"><i class="fas fa-file-csv me-2"></i> CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-calendar-alt text-info me-2"></i> Yearly Trends
                        </h5>
                        <p class="card-text">Year-wise research output analysis with growth trends.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <div class="btn-group report-btn-group">
                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Generate
                            </button>
                            <ul class="dropdown-menu report-dropdown">
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=year&format=pdf"><i class="fas fa-file-pdf me-2"></i> PDF</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=year&format=excel"><i class="fas fa-file-excel me-2"></i> Excel</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=year&format=csv"><i class="fas fa-file-csv me-2"></i> CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-flask text-warning me-2"></i> Research Design Analysis
                        </h5>
                        <p class="card-text">Breakdown of papers by research methodologies and designs.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <div class="btn-group report-btn-group">
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Generate
                            </button>
                            <ul class="dropdown-menu report-dropdown">
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=methodology&format=pdf"><i class="fas fa-file-pdf me-2"></i> PDF</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=methodology&format=excel"><i class="fas fa-file-excel me-2"></i> Excel</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=methodology&format=csv"><i class="fas fa-file-csv me-2"></i> CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-align-left text-danger me-2"></i> Abstract Report
                        </h5>
                        <p class="card-text">Detailed report including full abstracts of research papers.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <div class="btn-group report-btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Generate
                            </button>
                            <ul class="dropdown-menu report-dropdown">
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=abstract&format=pdf"><i class="fas fa-file-pdf me-2"></i> PDF</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=abstract&format=excel"><i class="fas fa-file-excel me-2"></i> Excel</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=abstract&format=csv"><i class="fas fa-file-csv me-2"></i> CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-user-tie text-secondary me-2"></i> Adviser Report
                        </h5>
                        <p class="card-text">Breakdown of research papers by faculty advisers.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <div class="btn-group report-btn-group">
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Generate
                            </button>
                            <ul class="dropdown-menu report-dropdown">
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=adviser&format=pdf"><i class="fas fa-file-pdf me-2"></i> PDF</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=adviser&format=excel"><i class="fas fa-file-excel me-2"></i> Excel</a></li>
                                <li><a class="dropdown-item report-link" href="{{ url('/research-statistics/generate-report') }}?type=adviser&format=csv"><i class="fas fa-file-csv me-2"></i> CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  

    <!-- Custom Report Modal - No longer needed as integrated into tab -->

    <!-- Load CSS & JS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
        // Define chart colors
        const chartColors = [
            'rgba(78, 115, 223, 0.8)',
            'rgba(28, 200, 138, 0.8)',
            'rgba(54, 185, 204, 0.8)',
            'rgba(246, 194, 62, 0.8)',
            'rgba(231, 74, 59, 0.8)',
            'rgba(116, 83, 204, 0.8)',
            'rgba(247, 37, 133, 0.8)',
            'rgba(61, 164, 171, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(75, 192, 192, 0.8)'
        ];
        
        // Chart instances
        let courseChart, yearChart, methodologyChart, categoryChart, heatmapChart, trendChart;
        
        $(document).ready(function() {
            $('#customReportBtn').on('click', function(e) {
        e.preventDefault();
        $('#statsTab button[data-bs-target="#reports"]').tab('show');
    });
    $('.dropdown-toggle').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const dropdown = $(this).parent();
    
    // Close all other dropdowns
    $('.dropdown').not(dropdown).removeClass('show');
    $('.dropdown-menu').not(dropdown.find('.dropdown-menu')).removeClass('show');
    
    // Toggle current dropdown
    dropdown.toggleClass('show');
    dropdown.find('.dropdown-menu').toggleClass('show');
});

// Close dropdowns when clicking outside
$(document).on('click', function(e) {
    if (!$(e.target).closest('.dropdown').length) {
        $('.dropdown').removeClass('show');
        $('.dropdown-menu').removeClass('show');
    }
});

// Make sure dropdown items work
$('.dropdown-item').on('click', function(e) {
    if ($(this).attr('href') && $(this).attr('href') !== '#') {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    }
});

            // Handle any tab switching
            $('#statsTab button').on('shown.bs.tab', function (e) {
                // Resize charts when tab is shown for better rendering
                if (e.target.id === 'visualization-tab') {
                    if (courseChart) courseChart.resize();
                    if (yearChart) yearChart.resize();
                    if (methodologyChart) methodologyChart.resize();
                    if (categoryChart) categoryChart.resize();
                    if (heatmapChart) heatmapChart.resize();
                    if (trendChart) trendChart.resize();
                }
            });
            $('.dropdown-item[href*="generate-report"]').on('click', function(e) {
    e.preventDefault();
    const reportUrl = $(this).attr('href');
    
    // Show loading
    Swal.fire({
        title: 'Generating Report',
        html: 'Please wait while we generate your report...',
        allowOutsideClick: false,
        timer: 3000, // Auto-close after 3 seconds
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            // Create a hidden iframe to trigger the download without page navigation
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = reportUrl;
            document.body.appendChild(iframe);
            
            // Clean up iframe after download starts
            setTimeout(() => {
                document.body.removeChild(iframe);
                Swal.close();
            }, 2000);
        }
    });
});
            // Initialize DataTable
            $('#researchTable').DataTable({
                responsive: true,
                order: [[2, 'desc']], // Sort by year by default
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search research papers...",
                    lengthMenu: "_MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "Showing 0 to 0 of 0 records",
                    infoFiltered: "(filtered from _MAX_ total records)"
                }
            });
            
            // Initialize Charts
            initCourseChart();
            initYearChart();
            initMethodologyChart();
            initCategoryChart();
            initHeatmapChart();
            initTrendChart();
            
            // Handle chart type changes
            $('.course-chart-type').on('click', function(e) {
                e.preventDefault();
                updateChartType('course', $(this).data('type'));
            });
            
            $('.year-chart-type').on('click', function(e) {
                e.preventDefault();
                updateChartType('year', $(this).data('type'));
            });
            
            $('.methodology-chart-type').on('click', function(e) {
                e.preventDefault();
                updateChartType('methodology', $(this).data('type'));
            });
            
            $('.category-chart-type').on('click', function(e) {
                e.preventDefault();
                updateChartType('category', $(this).data('type'));
            });
            
            // Chart download functionality
            $('.download-chart').on('click', function(e) {
                e.preventDefault();
                const chartId = $(this).data('chart');
                downloadChart(chartId);
            });
            
            // Download all charts
            $('#downloadAllCharts').on('click', function(e) {
                e.preventDefault();
                downloadAllCharts();
            });
            
            // Refresh charts
            $('#refreshCharts').on('click', function(e) {
                e.preventDefault();
                refreshAllCharts();
            });
            
            // Special charts functionality
            $('#reverseHeatmapColors').on('click', function(e) {
                e.preventDefault();
                reverseHeatmapColors();
            });
            
            $('#normalizeHeatmap').on('click', function(e) {
                e.preventDefault();
                normalizeHeatmap();
            });
            
            $('#showTrendline').on('click', function(e) {
                e.preventDefault();
                toggleTrendline();
            });
            
            $('#toggleCumulative').on('click', function(e) {
                e.preventDefault();
                toggleCumulativeData();
            });
            
            // Custom Report Form Handlers
            $('#allCourses').on('change', function() {
                $('.course-checkbox').prop('disabled', $(this).is(':checked'));
            });
            
            $('#allDesigns').on('change', function() {
                $('.design-checkbox').prop('disabled', $(this).is(':checked'));
            });
            
            $('#allCategories').on('change', function() {
                $('.category-checkbox').prop('disabled', $(this).is(':checked'));
            });
            
            // Clear form button
            $('#clearFormBtn').on('click', function() {
                // Reset form elements
                $('#customReportForm')[0].reset();
                
                // Re-disable checkboxes
                $('.course-checkbox').prop('disabled', true);
                $('.design-checkbox').prop('disabled', true);
                $('.category-checkbox').prop('disabled', true);
                
                // Show SweetAlert confirmation
                Swal.fire({
                    title: 'Form Cleared',
                    text: 'The form has been reset to default values.',
                    icon: 'info',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            });
            
            // Generate custom report with SweetAlert confirmation
            $('#customReportForm').on('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Generate Report',
        text: 'Are you sure you want to generate this custom report?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, generate report'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            showLoading();
            
            // Set form to open in new tab
            this.target = '_blank';
            
            // Submit the form
            this.submit();
            
            // Hide loading overlay after a short delay
            // This ensures the form submission has time to complete
            setTimeout(() => {
                hideLoading();
                
                // Show success message
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Report generation started in new tab',
                    showConfirmButton: false,
                    timer: 3000
                });
            }, 1500);
        }
    });
});
            // Original report generation buttons
            $('#generateFullReport, #generateCourseReport, #generateYearReport, #generateDesignReport').on('click', function(e) {
        e.preventDefault();
        
        let reportType = 'all';
        let reportTitle = 'Complete Report';
        
        if (this.id === 'generateCourseReport') {
            reportType = 'course';
            reportTitle = 'Course Statistics Report';
        } else if (this.id === 'generateYearReport') {
            reportType = 'year';
            reportTitle = 'Yearly Trends Report';
        } else if (this.id === 'generateDesignReport') {
            reportType = 'methodology';
            reportTitle = 'Research Design Analysis';
        }
        
        // Show format selection dialog
        Swal.fire({
            title: `Generate ${reportTitle}`,
            html: `
                <p>Choose the export format:</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="button" class="btn btn-outline-danger format-btn" data-format="pdf">
                        <i class="fas fa-file-pdf fs-2 d-block mb-2"></i>PDF
                    </button>
                    <button type="button" class="btn btn-outline-success format-btn" data-format="excel">
                        <i class="fas fa-file-excel fs-2 d-block mb-2"></i>Excel
                    </button>
                    <button type="button" class="btn btn-outline-primary format-btn" data-format="csv">
                        <i class="fas fa-file-csv fs-2 d-block mb-2"></i>CSV
                    </button>
                </div>
            `,
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Cancel',
            customClass: {
                container: 'format-selector-container'
            },
            didOpen: () => {
                // Add click event to format buttons
                $('.format-btn').on('click', function() {
                    const format = $(this).data('format');
                    
                    // Close the dialog
                    Swal.close();
                    
                    // Show loading
                    Swal.fire({
                        title: 'Generating Report',
                        html: `Creating ${format.toUpperCase()} report...`,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Redirect to generate report
                    window.location.href = `${window.location.origin}/research-statistics/generate-report?type=${reportType}&format=${format}`;
                });
            }
        });
    });
});
        // Initialize Course Chart
        function initCourseChart() {
            const ctx = document.getElementById('courseChart').getContext('2d');
            
            const courseLabels = {!! json_encode($courseData->pluck('course')) !!};
            const courseCounts = {!! json_encode($courseData->pluck('count')) !!};
            
            courseChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: courseLabels,
                    datasets: [{
                        label: 'Number of Papers',
                        data: courseCounts,
                        backgroundColor: chartColors,
                        borderColor: chartColors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Papers: ${context.raw}`;
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            color: 'white',
                            font: {
                                weight: 'bold'
                            },
                            formatter: function(value) {
                                return value;
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize Year Chart
        function initYearChart() {
            const ctx = document.getElementById('yearChart').getContext('2d');
            
            const yearLabels = {!! json_encode($yearData->pluck('year')) !!};
            const yearCounts = {!! json_encode($yearData->pluck('count')) !!};
            
            yearChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: yearLabels,
                    datasets: [{
                        label: 'Number of Papers',
                        data: yearCounts,
                        backgroundColor: 'rgba(78, 115, 223, 0.2)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Papers: ${context.raw}`;
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            anchor: 'end',
                            align: 'top',
                            formatter: function(value) {
                                return value;
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize Methodology Chart
        function initMethodologyChart() {
            const ctx = document.getElementById('methodologyChart').getContext('2d');
            
            const methodLabels = {!! json_encode($methodologyData->pluck('research_design')) !!}.map(label => label || 'Not Specified');
            const methodCounts = {!! json_encode($methodologyData->pluck('count')) !!};
            
            methodologyChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: methodLabels,
                    datasets: [{
                        data: methodCounts,
                        backgroundColor: chartColors,
                        borderColor: chartColors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((sum, value) => sum + value, 0);
                                    const percentage = Math.round((context.raw / total) * 100);
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            formatter: function(value, context) {
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const percentage = Math.round((value / total) * 100);
                                return percentage > 5 ? `${percentage}%` : '';
                            }
                        }
                    }
                }
            });
        }w
        
        // Initialize Category Chart
        function initCategoryChart() {
            const ctx = document.getElementById('categoryChart').getContext('2d');
            
            const categoryLabels = {!! json_encode($categoryData->pluck('category')) !!}.map(label => label || 'Not Specified');
            const categoryCounts = {!! json_encode($categoryData->pluck('count')) !!};
            
            categoryChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryCounts,
                        backgroundColor: chartColors,
                        borderColor: chartColors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((sum, value) => sum + value, 0);
                                    const percentage = Math.round((context.raw / total) * 100);
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            formatter: function(value, context) {
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const percentage = Math.round((value / total) * 100);
                                return percentage > 5 ? `${percentage}%` : '';
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize Heatmap Chart
        function initHeatmapChart() {
            const ctx = document.getElementById('heatmapChart');
            
            // If element doesn't exist, return
            if (!ctx) return;
            
            const courseLabels = {!! json_encode($courseData->pluck('course')) !!};
            const yearLabels = {!! json_encode($yearData->pluck('year')) !!}.sort();
            
            // Create dataset for heatmap
            const datasets = [];
            const heatmapData = [];
            
            // Fetch course by year data
            @foreach($courseData as $course)
                const {{ Str::slug($course->course) }}Data = [];
                @foreach($yearData as $year)
                    // Count research papers for this course and year
                    const count_{{ Str::slug($course->course) }}_{{ $year->year }} = 
                        {{ $researches->where('course', $course->course)->where('year', $year->year)->count() }};
                    {{ Str::slug($course->course) }}Data.push(count_{{ Str::slug($course->course) }}_{{ $year->year }});
                @endforeach
                heatmapData.push({{ Str::slug($course->course) }}Data);
            @endforeach
            
            // Generate colorized heatmap data
            const maxValue = Math.max(...heatmapData.map(row => Math.max(...row)));
            
            // Create datasets in format Chart.js can use
            for (let i = 0; i < courseLabels.length; i++) {
                datasets.push({
                    label: courseLabels[i],
                    data: heatmapData[i].map((value, j) => ({
                        x: yearLabels[j],
                        y: courseLabels[i],
                        v: value // Original value for tooltip
                    })),
                    backgroundColor: function(context) {
                        const value = context.raw ? context.raw.v : 0;
                        const alpha = value / maxValue;
                        return `rgba(54, 162, 235, ${alpha})`;
                    },
                    borderColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 1,
                    hoverBackgroundColor: 'rgba(75, 192, 192, 0.6)'
                });
            }
            
            heatmapChart = new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: 'category',
                            position: 'bottom',
                            title: {
                                display: true,
                                text: 'Year'
                            },
                            ticks: {
                                autoSkip: false
                            }
                        },
                        y: {
                            type: 'category',
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Course'
                            },
                            reverse: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const point = context.raw;
                                    return `${point.y} (${point.x}): ${point.v} papers`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
        
        // Initialize Trend Chart
        function initTrendChart() {
            const ctx = document.getElementById('trendChart');
            
            // If element doesn't exist, return
            if (!ctx) return;
            
            const yearLabels = {!! json_encode($yearData->pluck('year')) !!}.sort();
            const yearCounts = [];
            
            // Map years to counts while preserving order
            yearLabels.forEach(year => {
                const yearData = {!! json_encode($yearData) !!}.find(item => item.year == year);
                yearCounts.push(yearData ? yearData.count : 0);
            });
            
            // Calculate trend line
            const n = yearLabels.length;
            const indices = Array.from({length: n}, (_, i) => i);
            
            // Simple linear regression
            const sumX = indices.reduce((a, b) => a + b, 0);
            const sumY = yearCounts.reduce((a, b) => a + b, 0);
            const sumXY = indices.reduce((sum, x, i) => sum + x * yearCounts[i], 0);
            const sumXX = indices.reduce((sum, x) => sum + x * x, 0);
            
            const slope = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
            const intercept = (sumY - slope * sumX) / n;
            
            // Generate trend line data
            const trendData = indices.map(i => intercept + slope * i);
            
            trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: yearLabels,
                    datasets: [
                        {
                            label: 'Papers per Year',
                            data: yearCounts,
                            backgroundColor: 'rgba(78, 115, 223, 0.2)',
                            borderColor: 'rgba(78, 115, 223, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                            tension: 0.1,
                            order: 1
                        },
                        {
                            label: 'Trend Line',
                            data: trendData,
                            borderColor: 'rgba(255, 99, 132, 0.8)',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            borderDash: [5, 5],
                            borderWidth: 2,
                            pointRadius: 0,
                            fill: false,
                            tension: 0,
                            order: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        },
                        datalabels: {
                            display: function(context) {
                                return context.datasetIndex === 0; // Only show for actual data, not trendline
                            },
                            anchor: 'end',
                            align: 'top',
                            formatter: function(value, context) {
                                return context.datasetIndex === 0 ? value : '';
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            title: {
                                display: true,
                                text: 'Number of Papers'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Year'
                            }
                        }
                    }
                }
            });
        }
        
        // Update chart type
        function updateChartType(chartId, newType) {
            let chart;
            
            // Get the correct chart instance
            switch(chartId) {
                case 'course':
                    chart = courseChart;
                    break;
                case 'year':
                    chart = yearChart;
                    break;
                case 'methodology':
                    chart = methodologyChart;
                    break;
                case 'category':
                    chart = categoryChart;
                    break;
            }
            
            if (!chart) return;
            
            // Special handling for 'area' type which is a line chart with fill
            if (newType === 'area') {
                newType = 'line';
                chart.data.datasets.forEach(dataset => {
                    dataset.fill = true;
                });
            } else {
                chart.data.datasets.forEach(dataset => {
                    dataset.fill = false;
                });
            }
            
            // Store current data
            const data = chart.data;
            
            // Destroy current chart
            chart.destroy();
            
            // Create context again
            const ctx = document.getElementById(`${chartId}Chart`).getContext('2d');
            
            // Set chart type
            const config = {
                type: newType,
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (newType === 'pie' || newType === 'doughnut') {
                                        const total = context.dataset.data.reduce((sum, value) => sum + value, 0);
                                        const percentage = Math.round((context.raw / total) * 100);
                                        return `${context.label}: ${context.raw} (${percentage}%)`;
                                    } else {
                                        return `Papers: ${context.raw}`;
                                    }
                                }
                            }
                        },
                        legend: {
                            display: (newType === 'pie' || newType === 'doughnut'),
                            position: 'right'
                        },
                        datalabels: {
                            display: true,
                            color: (newType === 'pie' || newType === 'doughnut') ? '#fff' : undefined,
                            formatter: function(value, context) {
                                if (newType === 'pie' || newType === 'doughnut') {
                                    const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return percentage > 5 ? `${percentage}%` : '';
                                } else {
                                    return value;
                                }
                            }
                        }
                    }
                }
            };
            
            // Add scales for bar and line charts
            if (newType === 'bar' || newType === 'line') {
                config.options.scales = {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                };
            }
            
            // Create new chart
            switch(chartId) {
                case 'course':
                    courseChart = new Chart(ctx, config);
                    break;
                case 'year':
                    yearChart = new Chart(ctx, config);
                    break;
                case 'methodology':
                    methodologyChart = new Chart(ctx, config);
                    break;
                case 'category':
                    categoryChart = new Chart(ctx, config);
                    break;
            }
            
            // Show success toast
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: `Chart updated to ${newType === 'area' ? 'area' : newType} view`,
                showConfirmButton: false,
                timer: 1500
            });
        }
        
        // Download chart as image
        function downloadChart(chartId) {
            let chart;
            
            // Get the correct chart instance
            switch(chartId) {
                case 'courseChart':
                    chart = courseChart;
                    break;
                case 'yearChart':
                    chart = yearChart;
                    break;
                case 'methodologyChart':
                    chart = methodologyChart;
                    break;
                case 'categoryChart':
                    chart = categoryChart;
                    break;
                case 'heatmapChart':
                    chart = heatmapChart;
                    break;
                case 'trendChart':
                    chart = trendChart;
                    break;
            }
            
            if (!chart) return;
            
            // Create temporary link
            const a = document.createElement('a');
            a.href = chart.toBase64Image('image/png', 1.0);
            a.download = `${chartId}_${new Date().toISOString()}.png`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            
            // Show success toast
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Chart downloaded successfully',
                showConfirmButton: false,
                timer: 1500
            });
        }
        
        // Download all charts
        function downloadAllCharts() {
            Swal.fire({
                title: 'Download All Charts',
                text: 'All charts will be downloaded as separate PNG files.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Download All'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Download each chart
                    if (courseChart) downloadChart('courseChart');
                    if (yearChart) downloadChart('yearChart');
                    if (methodologyChart) downloadChart('methodologyChart');
                    if (categoryChart) downloadChart('categoryChart');
                    if (heatmapChart) downloadChart('heatmapChart');
                    if (trendChart) downloadChart('trendChart');
                    
                    // Show success toast
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'All charts downloaded',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }
        
        // Refresh all charts
        function refreshAllCharts() {
            Swal.fire({
                title: 'Refreshing Charts',
                html: 'Please wait while we update the visualizations...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Simulate a delay for the refresh operation
            setTimeout(() => {
                // Destroy and re-initialize all charts
                if (courseChart) {
                    courseChart.destroy();
                    initCourseChart();
                }
                
                if (yearChart) {
                    yearChart.destroy();
                    initYearChart();
                }
                
                if (methodologyChart) {
                    methodologyChart.destroy();
                    initMethodologyChart();
                }
                
                if (categoryChart) {
                    categoryChart.destroy();
                    initCategoryChart();
                }
                
                if (heatmapChart) {
                    heatmapChart.destroy();
                    initHeatmapChart();
                }
                
                if (trendChart) {
                    trendChart.destroy();
                    initTrendChart();
                }
                
                // Close loading dialog
                Swal.close();
                
                // Show success toast
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'All charts refreshed',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 1000);
        }
        
        // Reverse heatmap colors
        function reverseHeatmapColors() {
            if (!heatmapChart) return;
            
            // Toggle between blue and red color schemes
            const isBlue = heatmapChart.data.datasets[0].backgroundColor.toString().includes('rgba(54, 162, 235');
            
            for (let i = 0; i < heatmapChart.data.datasets.length; i++) {
                heatmapChart.data.datasets[i].backgroundColor = function(context) {
                    const value = context.raw ? context.raw.v : 0;
                    const maxValue = Math.max(...heatmapChart.data.datasets.map(dataset => 
                        Math.max(...dataset.data.map(point => point.v))
                    ));
                    const alpha = value / maxValue;
                    
                    return isBlue 
                        ? `rgba(255, 99, 132, ${alpha})`  // Red
                        : `rgba(54, 162, 235, ${alpha})`; // Blue
                };
                
                heatmapChart.data.datasets[i].hoverBackgroundColor = isBlue
                    ? 'rgba(255, 159, 64, 0.6)'   // Orange
                    : 'rgba(75, 192, 192, 0.6)';  // Teal
            }
            
            heatmapChart.update();
            
            // Show success toast
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: `Heatmap colors ${isBlue ? 'inverted' : 'restored'}`,
                showConfirmButton: false,
                timer: 1500
            });
        }
        
        // Normalize heatmap data
        function normalizeHeatmap() {
            if (!heatmapChart) return;
            
            // Toggle between absolute and relative values
            const firstDataset = heatmapChart.data.datasets[0];
            const isNormalized = firstDataset._normalized || false;
            
            // Calculate row sums for normalization
            const rowSums = heatmapChart.data.datasets.map(dataset => 
                dataset.data.reduce((sum, point) => sum + point.v, 0)
            );
            
            for (let i = 0; i < heatmapChart.data.datasets.length; i++) {
                const dataset = heatmapChart.data.datasets[i];
                
                if (!isNormalized) {
                    // Store original values if not already stored
                    if (!dataset._originalData) {
                        dataset._originalData = dataset.data.map(point => ({...point}));
                    }
                    
                    // Normalize values by row (course)
                    for (let j = 0; j < dataset.data.length; j++) {
                        const originalValue = dataset.data[j].v;
                        dataset.data[j].v = rowSums[i] > 0 
                            ? Math.round((originalValue / rowSums[i]) * 100) 
                            : 0;
                    }
                    
                    dataset._normalized = true;
                } else {
                    // Restore original values
                    dataset.data = dataset._originalData.map(point => ({...point}));
                    dataset._normalized = false;
                }
            }
            
            // Update tooltip callback to show percentage or absolute value
            const tooltipCallback = isNormalized
                ? function(context) {
                    const point = context.raw;
                    return `${point.y} (${point.x}): ${point.v} papers`;
                }
                : function(context) {
                    const point = context.raw;
                    return `${point.y} (${point.x}): ${point.v}%`;
                };
            
            heatmapChart.options.plugins.tooltip.callbacks.label = tooltipCallback;
            
            heatmapChart.update();
            
            // Show success toast
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: `Heatmap ${isNormalized ? 'absolute values' : 'percentage values'} displayed`,
                showConfirmButton: false,
                timer: 1500
            });
        }
        
        // Toggle trend line visibility
        function toggleTrendline() {
            if (!trendChart) return;
            
            const trendlineDataset = trendChart.data.datasets[1];
            trendlineDataset.hidden = !trendlineDataset.hidden;
            
            trendChart.update();
            
            // Show success toast
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: `Trend line ${trendlineDataset.hidden ? 'hidden' : 'shown'}`,
                showConfirmButton: false,
                timer: 1500
            });
        }
        
        // Toggle cumulative data
        function toggleCumulativeData() {
            if (!trendChart) return;
            
            const mainDataset = trendChart.data.datasets[0];
            const isCumulative = mainDataset._cumulative || false;
            
            if (!isCumulative) {
                // Store original data if not already stored
                if (!mainDataset._originalData) {
                    mainDataset._originalData = [...mainDataset.data];
                }
                
                // Calculate cumulative values
                const cumulativeData = [];
                let sum = 0;
                
                for (let i = 0; i < mainDataset.data.length; i++) {
                    sum += mainDataset.data[i];
                    cumulativeData.push(sum);
                }
                
                mainDataset.data = cumulativeData;
                mainDataset.label = 'Cumulative Papers';
                mainDataset._cumulative = true;
                
                // Hide trend line as it doesn't apply to cumulative data
                trendChart.data.datasets[1].hidden = true;
            } else {
                // Restore original data
                mainDataset.data = mainDataset._originalData;
                mainDataset.label = 'Papers per Year';
                mainDataset._cumulative = false;
                
                // Show trend line again
                trendChart.data.datasets[1].hidden = false;
            }
            
            trendChart.update();
            
            // Show success toast
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: `Switched to ${isCumulative ? 'yearly' : 'cumulative'} data`,
                showConfirmButton: false,
                timer: 1500
            });
        }
        // DROPDOWN FIX - DIRECT IMPLEMENTATION
document.addEventListener('DOMContentLoaded', function() {
    // Find all dropdown toggles
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    // Add click event listeners to each toggle
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Get parent dropdown
            const dropdown = this.closest('.dropdown, .btn-group');
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown.show, .btn-group.show').forEach(openDropdown => {
                if (openDropdown !== dropdown) {
                    openDropdown.classList.remove('show');
                    const menu = openDropdown.querySelector('.dropdown-menu');
                    if (menu) menu.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
            const menu = dropdown.querySelector('.dropdown-menu');
            if (menu) menu.classList.toggle('show');
        });
    });
    
    // Close all dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown, .btn-group')) {
            document.querySelectorAll('.dropdown.show, .btn-group.show').forEach(dropdown => {
                dropdown.classList.remove('show');
                const menu = dropdown.querySelector('.dropdown-menu');
                if (menu) menu.classList.remove('show');
            });
        }
    });
    
    // Make dropdown items work
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href !== '#') {
                e.preventDefault();
                window.location.href = href;
            }
        });
    });
    
    // Report generation buttons
    document.querySelectorAll('#generateFullReport, #generateCourseReport, #generateYearReport, #generateDesignReport').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            let reportType = 'all';
            let reportTitle = 'Complete Report';
            
            if (this.id === 'generateCourseReport') {
                reportType = 'course';
                reportTitle = 'Course Statistics Report';
            } else if (this.id === 'generateYearReport') {
                reportType = 'year';
                reportTitle = 'Yearly Trends Report';
            } else if (this.id === 'generateDesignReport') {
                reportType = 'methodology';
                reportTitle = 'Research Design Analysis';
            }
            
            // Use SweetAlert to show format options
            Swal.fire({
                title: `Generate ${reportTitle}`,
                html: `
                    <p>Choose the export format:</p>
                    <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 1rem;">
                        <button type="button" class="btn btn-outline-danger format-btn" data-format="pdf">
                            <i class="fas fa-file-pdf" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>PDF
                        </button>
                        <button type="button" class="btn btn-outline-success format-btn" data-format="excel">
                            <i class="fas fa-file-excel" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>Excel
                        </button>
                        <button type="button" class="btn btn-outline-primary format-btn" data-format="csv">
                            <i class="fas fa-file-csv" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>CSV
                        </button>
                    </div>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Cancel',
                didOpen: () => {
                    // Add click event to format buttons
                    document.querySelectorAll('.format-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const format = this.getAttribute('data-format');
                            
                            // Close the dialog
                            Swal.close();
                            
                            // Show loading
                            Swal.fire({
                                title: 'Generating Report',
                                html: `Creating ${format.toUpperCase()} report...`,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
                            // Redirect to generate report
                            window.location.href = `${window.location.origin}/research-statistics/generate-report?type=${reportType}&format=${format}`;
                        });
                    });
                }
            });
        });
    });
});
    </script>
    
    <style>
        /* Tab Styling */
        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 500;
            border-bottom: 3px solid transparent;
        }
        
        .nav-tabs .nav-link.active {
            color: #4e73df;
            background: transparent;
            border-bottom: 3px solid #4e73df;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            border-bottom: 3px solid #e2e8f0;
        }
        
        /* Chart container styles */
        .chart-container {
            height: 300px;
            position: relative;
        }
        
        /* Card left border accent styles */
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        
        /* Format selector in SweetAlert */
        .format-selector-container .format-btn {
            min-width: 100px;
            transition: all 0.2s;
        }
        
        .format-selector-container .format-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        /* Dark Mode Compatible Styles */
        .dark .card {
            background-color: #1f2937;
            color: #e5e7eb;
        }
        
        .dark .card-header {
            background-color: #111827 !important;
            border-bottom: 1px solid #374151;
        }
        
        .dark .text-gray-800 {
            color: #e5e7eb !important;
        }
        
        .dark .text-gray-300 {
            color: #9ca3af !important;
        }
        
        .dark .form-control,
        .dark .form-select {
            background-color: #374151;
            color: #e5e7eb;
            border-color: #4b5563;
        }
        
        .dark .form-check-input {
            background-color: #374151;
            border-color: #6b7280;
        }
        
        .dark .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
/* CSS to ensure dropdowns display properly */
.dropdown-menu {
    position: absolute;
    z-index: 1000;
    display: none;
    min-width: 10rem;
    padding: 0.5rem 0;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 0.25rem;
}

.dropdown-menu.show,
.btn-group.show .dropdown-menu {
    display: block !important;
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 0.25rem 1.5rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    cursor: pointer;
}

.dropdown-item:hover, .dropdown-item:focus {
    color: #16181b;
    text-decoration: none;
    background-color: #f8f9fa;
}

/* Dark mode compatibility */
.dark .dropdown-menu {
    background-color: #374151;
    border-color: #4b5563;
}

.dark .dropdown-item {
    color: #e5e7eb;
}

.dark .dropdown-item:hover, 
.dark .dropdown-item:focus {
    background-color: #4b5563;
}
/* Dark Mode Fixes for Bootstrap Components */
.dark .card,
.dark .bg-white {
    background-color: #1f2937 !important;
    color: #e5e7eb !important;
}

.dark .table,
.dark .table-bordered,
.dark .dataTable {
    color: #e5e7eb !important;
}

.dark .table th,
.dark .table td,
.dark .table-bordered th,
.dark .table-bordered td {
    border-color: #4b5563 !important;
}

.dark .form-control,
.dark .form-select,
.dark .form-check-input {
    background-color: #374151 !important;
    color: #e5e7eb !important;
    border-color: #4b5563 !important;
}

.dark .btn-outline-primary,
.dark .btn-outline-secondary,
.dark .btn-outline-danger,
.dark .btn-outline-success {
    color: #e5e7eb !important;
    border-color: #4b5563 !important;
}

.dark .nav-tabs {
    border-bottom-color: #4b5563 !important;
}

.dark .nav-tabs .nav-link {
    color: #9ca3af !important;
}

.dark .nav-tabs .nav-link.active {
    color: #3b82f6 !important;
    background-color: transparent !important;
}

.dark .dropdown-menu {
    background-color: #1f2937 !important;
    border-color: #4b5563 !important;
}

.dark .dropdown-item {
    color: #e5e7eb !important;
}

.dark .dropdown-item:hover,
.dark .dropdown-item:focus {
    background-color: #374151 !important;
}

.dark .table-responsive {
    color: #e5e7eb !important;
}

.dark .dataTables_wrapper .dataTables_length,
.dark .dataTables_wrapper .dataTables_filter,
.dark .dataTables_wrapper .dataTables_info {
    color: #e5e7eb !important;
}

.dark .dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #e5e7eb !important;
}

.dark .card-header.py-3,
.dark .card-header {
    background-color: #1f2937 !important;
    border-bottom-color: #4b5563 !important;
}

/* Fix for Bootstrap dropdowns */
.dark .dropdown-toggle,
.dark .dropdown-toggle:after {
    color: #e5e7eb !important;
}

/* Fix for chart containers */
.dark .chart-container canvas {
    background-color: #1f2937 !important;
}
        </style>
     </x-app-layout>