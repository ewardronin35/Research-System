<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Academic Research Repository - Browse research papers across various disciplines">
    <title>Research Repository</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #4cc9f0;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #06d6a0;
            --warning: #ffd166;
            --danger: #ef476f;
            --info: #118ab2;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-800: #343a40;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            color: #333;
            background-color: #fafafa;
        }
        
        /* Navbar Styling */
        .navbar {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-dark);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--gray-800);
            position: relative;
            margin: 0 8px;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary);
            bottom: 0;
            left: 0;
            transition: width 0.3s;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .nav-link.active:after {
            width: 100%;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.9), rgba(58, 12, 163, 0.9)),
                        url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
            min-height: 65vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100px;
            bottom: -50px;
            left: 0;
            background: #fafafa;
            transform: skewY(-2deg);
            z-index: 1;
        }
        
        .hero-content {
            z-index: 2;
            color: white;
        }
        
        .hero-title {
            font-weight: 800;
            font-size: 3.2rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-weight: 400;
            font-size: 1.3rem;
            margin-bottom: 30px;
            max-width: 700px;
        }
        
        /* Search Container */
        .search-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-top: -80px;
            position: relative;
            z-index: 3;
        }
        
        .search-title {
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--dark);
            text-align: center;
        }
        
        .filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .filter-chip {
            display: inline-block;
            background: var(--gray-200);
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            color: var(--dark);
        }
        
        .filter-chip:hover {
            background: var(--gray-300);
        }
        
        .filter-chip.active {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-modern {
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: none;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
        }
        
        .input-group {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 50px;
            overflow: hidden;
        }
        
        .input-group-text {
            background-color: white;
            border-right: none;
        }
        
        .form-control {
            border-left: none;
            padding: 12px 20px;
            border-radius: 0;
        }
        
        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        
        .form-select {
            padding: 12px 20px;
            border-radius: 50px;
            cursor: pointer;
        }
        
        /* Research Tables */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 50px;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        #researchTable {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        #researchTable thead th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
        }
        
        #researchTable thead th:first-child {
            border-top-left-radius: 10px;
        }
        
        #researchTable thead th:last-child {
            border-top-right-radius: 10px;
        }
        
        #researchTable tbody tr {
            transition: all 0.2s;
        }
        
        #researchTable tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        #researchTable tbody td {
            vertical-align: middle;
            padding: 15px;
            border-top: none;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .badge-course {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.8rem;
        }
        
        .badge-bsn {
            background-color: var(--warning);
            color: var(--dark);
        }
        
        .badge-stem {
            background-color: var(--info);
            color: white;
        }
        
        .badge-humms {
            background-color: var(--danger);
            color: white;
        }
        
        .badge-abm {
            background-color: var(--success);
            color: white;
        }
        
        .badge-bscs, .badge-bsit {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-action {
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 24px;
            color: white;
        }
        
        .stats-icon-research {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }
        
        .stats-icon-researchers {
            background: linear-gradient(135deg, var(--info), var(--secondary));
        }
        
        .stats-icon-advisers {
            background: linear-gradient(135deg, var(--warning), var(--success));
        }
        
        .stats-icon-programs {
            background: linear-gradient(135deg, var(--danger), var(--accent));
        }
        
        .stats-count {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Category Cards */
        .category-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            position: relative;
            height: 100%;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .category-icon {
            font-size: 30px;
            margin-bottom: 20px;
            width: 70px;
            height: 70px;
            line-height: 70px;
            border-radius: 50%;
            text-align: center;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(76, 201, 240, 0.1));
            color: var(--primary);
        }
        
        .category-title {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
        
        .category-description {
            font-size: 0.95rem;
            color: #6c757d;
            margin-bottom: 15px;
        }
        
        .category-card .btn {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .category-card .btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--primary-dark);
            transition: width 0.3s;
            z-index: -1;
        }
        
        .category-card .btn:hover:before {
            width: 100%;
        }
        
        /* Research Modal */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .modal-header {
            border-bottom: none;
            padding: 25px 30px 0;
        }
        
        .modal-body {
            padding: 20px 30px;
        }
        
        .modal-footer {
            border-top: none;
            padding: 0 30px 25px;
            justify-content: space-between;
        }
        
        .paper-header {
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .paper-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }
        
        .paper-meta {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        
        .paper-meta i {
            color: var(--primary);
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .paper-section-title {
            font-weight: 600;
            margin: 25px 0 15px;
            color: var(--primary-dark);
        }
        
        .paper-keywords .badge {
            padding: 8px 15px;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 50px;
            font-weight: 500;
            background-color: var(--gray-200);
            color: var(--dark);
        }
        
        /* Filter Results Banner */
        .filter-results-banner {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 10px;
            padding: 15px 25px;
            margin-bottom: 20px;
            display: none;
        }
        
        .filter-tag {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 5px 15px;
            margin-right: 10px;
            margin-bottom: 5px;
            font-size: 0.85rem;
        }
        
        .filter-tag i {
            margin-right: 5px;
        }
        
        .clear-filter {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 5px 15px;
            color: white;
            border: none;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        
        .clear-filter:hover {
            background: rgba(255, 255, 255, 0.4);
        }
        
        /* DataTable Custom Styles */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 50px;
            padding: 8px 16px;
            border: 1px solid var(--gray-300);
            margin-left: 10px;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border-radius: 50px;
            padding: 5px 30px 5px 15px;
            border: 1px solid var(--gray-300);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
            border-radius: 50px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--gray-200) !important;
            border-color: var(--gray-200) !important;
            color: var(--dark) !important;
            border-radius: 50px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 50px;
        }
        
        .dataTables_info, .dataTables_length, .dataTables_filter {
            font-size: 0.9rem;
            color: var(--gray-800);
        }
        
        /* Export buttons */
        .dt-buttons .btn {
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 0.875rem;
            margin-right: 5px;
            box-shadow: none;
        }

        /* Footer */
        .footer {
            background-color: var(--dark);
            color: white;
            padding: 70px 0 20px;
        }
        
        .footer-logo {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 20px;
            display: block;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 30px;
        }
        
        .footer h5 {
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-contact li {
            margin-bottom: 15px;
            display: flex;
        }
        
        .footer-contact i {
            margin-right: 15px;
            color: var(--primary);
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 50px;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .search-container {
                margin-top: -50px;
            }
        }
        
        @media (max-width: 767.98px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .search-container {
                margin-top: -30px;
                padding: 20px;
            }
            
            .stats-card {
                margin-bottom: 20px;
            }
            
            .paper-meta {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animated-element {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        /* Loading spinner */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .loading-overlay.show {
            visibility: visible;
            opacity: 1;
        }
        
        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid var(--gray-200);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-book-open me-2"></i> Research Repository
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home me-1"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#browse"><i class="fas fa-search me-1"></i> Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#statistics"><i class="fas fa-chart-bar me-1"></i> Statistics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories"><i class="fas fa-th-large me-1"></i> Categories</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                            </li>
                            <li class="nav-item ms-2">
                                <a class="btn btn-primary btn-modern" href="{{ url('/dashboard') }}">My Account</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item ms-2">
                                    <a class="btn btn-primary btn-modern" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 hero-content" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="hero-title">Discover Innovative Research</h1>
                    <p class="hero-subtitle">Explore academic research papers across various disciplines, methodologies, and topics to inspire your own scholarly journey.</p>
                    <a href="#browse" class="btn btn-light btn-modern">Start Browsing <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Container -->
    <section id="browse">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="search-container" data-aos="fade-up" data-aos-duration="1000">
                        <h3 class="search-title">Search Research Papers</h3>
                        
                        <div class="filter-results-banner mb-4" id="filterResultsBanner">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="filter-tags-container">
                                    <span class="me-2">Active filters:</span>
                                    <div class="active-filters d-inline-block" id="activeFilters">
                                        <!-- Active filters will be dynamically added here -->
                                    </div>
                                </div>
                                <button class="clear-filter" id="clearAllFilters">
                                    <i class="fas fa-times me-1"></i> Clear All
                                </button>
                            </div>
                        </div>
                        
                        <form id="searchForm">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text border-0">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control border-0" id="searchKeywords" placeholder="Search by title, keywords, or abstract...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="yearFilter">
                                        <option value="">All Years</option>
                                        @foreach(range(date('Y'), 2020) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-modern w-100">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Advanced Filter Accordion -->
                        <div class="accordion mb-4" id="advancedFilterAccordion">
                            <div class="accordion-item border-0 rounded">
                                <h2 class="accordion-header" id="headingAdvancedFilter">
                                    <button class="accordion-button collapsed bg-light rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdvancedFilter" aria-expanded="false" aria-controls="collapseAdvancedFilter">
                                        <i class="fas fa-sliders-h me-2"></i> Advanced Filters
                                    </button>
                                </h2>
                                <div id="collapseAdvancedFilter" class="accordion-collapse collapse" aria-labelledby="headingAdvancedFilter" data-bs-parent="#advancedFilterAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Research Type</label>
                                                <select class="form-select" id="researchTypeFilter">
                                                    <option value="">All Types</option>
                                                    <option value="Qualitative">Qualitative</option>
                                                    <option value="Quantitative">Quantitative</option>
                                                    <option value="Mixed Method">Mixed Method</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Research Design</label>
                                                <select class="form-select" id="researchDesignFilter">
                                                    <option value="">All Designs</option>
                                                    <option value="Phenomenology">Phenomenology</option>
                                                    <option value="Case Study">Case Study</option>
                                                    <option value="Narrative">Narrative</option>
                                                    <option value="Descriptive">Descriptive</option>
                                                    <option value="Multi-Case Study">Multi-Case Study</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Course/Program</label>
                                                <select class="form-select" id="courseFilter">
                                                    <option value="">All Courses</option>
                                                    <option value="BSN">BSN</option>
                                                    <option value="BSCS">BSCS</option>
                                                    <option value="BSIT">BSIT</option>
                                                    <option value="STEM">STEM</option>
                                                    <option value="HUMMS">HUMMS</option>
                                                    <option value="ABM">ABM</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Number of Respondents</label>
                                                <select class="form-select" id="respondentsFilter">
                                                    <option value="">Any</option>
                                                    <option value="1-50">1-50</option>
                                                    <option value="51-100">51-100</option>
                                                    <option value="101-200">101-200</option>
                                                    <option value="201+">201+</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mt-2 text-end">
                                                <button type="button" class="btn btn-primary btn-modern" id="applyAdvancedFilters">
                                                    <i class="fas fa-filter me-2"></i> Apply Filters
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Filter Pills -->
                        <div class="filter-section">
                            <p class="fw-bold mb-2">Quick Filters:</p>
                            <div class="filter-chips course-chips">
                                <button class="filter-chip active" data-filter="course" data-value="all">All Programs</button>
                                <button class="filter-chip" data-filter="course" data-value="BSN">BSN</button>
                                <button class="filter-chip" data-filter="course" data-value="BSCS">BSCS</button>
                                <button class="filter-chip" data-filter="course" data-value="BSIT">BSIT</button>
                                <button class="filter-chip" data-filter="course" data-value="STEM">STEM</button>
                                <button class="filter-chip" data-filter="course" data-value="HUMMS">HUMMS</button>
                                <button class="filter-chip" data-filter="course" data-value="ABM">ABM</button>
                            </div>
                            
                            <p class="fw-bold mb-2 mt-3">Research Design:</p>
                            <div class="filter-chips design-chips">
                                <button class="filter-chip active" data-filter="design" data-value="all">All Designs</button>
                                <button class="filter-chip" data-filter="design" data-value="Phenomenology">Phenomenology</button>
                                <button class="filter-chip" data-filter="design" data-value="Case Study">Case Study</button>
                                <button class="filter-chip" data-filter="design" data-value="Descriptive">Descriptive</button>
                                <button class="filter-chip" data-filter="design" data-value="Narrative">Narrative</button>
                                <button class="filter-chip" data-filter="design" data-value="Multi-Case Study">Multi-Case Study</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Research DataTable Section -->
    <section class="py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="filterResultsSummary" class="mb-4 alert alert-info d-none">
                        <h5 class="paper-section-title">Abstract</h5>
                        <p id="paperAbstract" class="mb-4"></p>
                        
                        <h5 class="paper-section-title">Keywords</h5>
                        <div class="paper-keywords" id="paperKeywords">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                    <a href="#" id="downloadPaperBtn" class="btn btn-primary btn-modern disabled">
                        <i class="fas fa-download me-1"></i> Download Paper
                    </a>
                </div>
            </div>
        </div>
    </div> class="m-0">
                            <i class="fas fa-info-circle me-2"></i> 
                            <span id="resultCount">0</span> research papers found matching your criteria
                        </h5>
                    </div>
                </div>
                
                <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="table-container">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                            <h3 class="m-0 fw-bold mb-2 mb-md-0">Research Database</h3>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-outline-primary btn-sm rounded-pill" id="toggleColumns">
                                    <i class="fas fa-columns me-1"></i> Toggle Columns
                                </button>
                                <div class="btn-group" id="exportButtons">
                                    <!-- Export buttons will be added here by DataTables -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table id="researchTable" class="table table-hover w-100">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Researchers</th>
                                        <th>Adviser</th>
                                        <th>Year</th>
                                        <th>Research Design</th>
                                        <th>Type</th>
                                        <th>Respondents</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be dynamically loaded via Ajax -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <a href="#" class="footer-logo text-white text-decoration-none">
                        <i class="fas fa-book-open me-2"></i> Research Repository
                    </a>
                    <p class="footer-text">A comprehensive collection of academic research papers from students and faculty across various disciplines and methodologies.</p>
                    <div class="social-links">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#browse">Browse</a></li>
                        <li><a href="#statistics">Statistics</a></li>
                        <li><a href="#categories">Categories</a></li>
                        <li><a href="#">About</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                    <h5>Programs</h5>
                    <ul class="footer-links">
                        <li><a href="#" data-course="BSN">BSN</a></li>
                        <li><a href="#" data-course="BSCS">BSCS</a></li>
                        <li><a href="#" data-course="BSIT">BSIT</a></li>
                        <li><a href="#" data-course="STEM">STEM</a></li>
                        <li><a href="#" data-course="HUMMS">HUMMS</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>Contact Us</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Education Ave, Academic City</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>(123) 456-7890</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>research@institution.edu</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-md-0">© {{ date('Y') }} Research Repository. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Terms of Service | Privacy Policy</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Initialize AOS animations
            AOS.init({
                once: true,
                offset: 100,
                duration: 800
            });
            
            // Show loading overlay
            function showLoading() {
                $('#loadingOverlay').addClass('show');
            }
            
            // Hide loading overlay
            function hideLoading() {
                $('#loadingOverlay').removeClass('show');
            }
            
            // Initialize statistics counters with default values
            $('#totalPapers').text(0);
            $('#totalResearchers').text(0);
            $('#totalAdvisers').text(0);
            $('#totalPrograms').text(0);
            
            // Fetch and initialize statistics
            function loadStatistics() {
                $.ajax({
                    url: '/api/statistics',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update stats counters
                        $('#totalPapers').text(data.totalPapers);
                        $('#totalResearchers').text(data.totalResearchers);
                        $('#totalAdvisers').text(data.totalAdvisers);
                        $('#totalPrograms').text(data.totalPrograms);
                        
                        // Animate counters
                        $('.counter').counterUp({
                            delay: 10,
                            time: 1000
                        });
                        
                        // Initialize program chart
                        const programCtx = document.getElementById('programChart').getContext('2d');
                        const programChart = new Chart(programCtx, {
                            type: 'doughnut',
                            data: {
                                labels: data.programStats.map(item => item.course),
                                datasets: [{
                                    data: data.programStats.map(item => item.count),
                                    backgroundColor: [
                                        '#4361ee', '#3a0ca3', '#4cc9f0', '#f72585', '#7209b7', '#480ca8'
                                    ],
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'right',
                                        labels: {
                                            font: {
                                                family: 'Inter',
                                                size: 12
                                            },
                                            padding: 20
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.label + ': ' + context.raw + ' papers';
                                            }
                                        }
                                    }
                                },
                                cutout: '65%'
                            }
                        });
                        
                        // Initialize design chart
                        const designCtx = document.getElementById('designChart').getContext('2d');
                        const designChart = new Chart(designCtx, {
                            type: 'bar',
                            data: {
                                labels: data.designStats.map(item => item.design),
                                datasets: [{
                                    label: 'Papers by Research Design',
                                    data: data.designStats.map(item => item.count),
                                    backgroundColor: '#4361ee',
                                    borderRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
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
                    },
                    error: function() {
                        console.error('Error fetching statistics');
                    }
                });
            }
            
            // Initialize DataTable with export buttons
            var table = $('#researchTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/api/research',
                    data: function(d) {
                        d.keywords = $('#searchKeywords').val();
                        d.year = $('#yearFilter').val();
                        d.course = $('.filter-chip[data-filter="course"].active').data('value');
                        d.design = $('.filter-chip[data-filter="design"].active').data('value');
                        d.research_type = $('#researchTypeFilter').val();
                        d.respondents = $('#respondentsFilter').val();
                    },
                    dataSrc: function(json) {
                        // Update filter results summary
                        $('#resultCount').text(json.recordsFiltered);
                        
                        if (
                            $('#searchKeywords').val() ||
                            $('#yearFilter').val() ||
                            $('.filter-chip[data-filter="course"].active').data('value') !== 'all' ||
                            $('.filter-chip[data-filter="design"].active').data('value') !== 'all' ||
                            $('#researchTypeFilter').val() ||
                            $('#respondentsFilter').val()
                        ) {
                            $('#filterResultsSummary').removeClass('d-none');
                        } else {
                            $('#filterResultsSummary').addClass('d-none');
                        }
                        
                        return json.data;
                    }
                },
                columns: [
                    { data: 'title' },
                    { 
                        data: 'course',
                        render: function(data) {
                            return '<span class="badge badge-course badge-' + data.toLowerCase() + '">' + data + '</span>';
                        }
                    },
                    { data: 'researchers' },
                    { data: 'adviser' },
                    { data: 'year' },
                    { data: 'research_design' },
                    { data: 'research_type' },
                    { data: 'respondents_count' },
                    {
                        data: 'id',
                        render: function(data) {
                            return '<button class="btn btn-primary btn-sm btn-action view-btn" data-id="' + data + '"><i class="fas fa-eye me-1"></i> View</button>';
                        },
                        orderable: false
                    }
                ],
                responsive: true,
                ordering: true,
                paging: true,
                lengthChange: true,
                info: true,
                autoWidth: false,
                dom: '<"row"<"col-md-6"B><"col-md-6"f>>rt<"row"<"col-md-6"l><"col-md-6"p>>',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel me-1"></i> Excel',
                        className: 'btn-outline-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                        className: 'btn-outline-danger',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print me-1"></i> Print',
                        className: 'btn-outline-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: [0] },
                    { responsivePriority: 2, targets: [1, 4] },
                    { responsivePriority: 3, targets: [8] },
                    { visible: false, targets: [6, 7] }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "_MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records available",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    zeroRecords: "No matching records found",
                    processing: "<div class='spinner-border text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>"
                },
                drawCallback: function() {
                    hideLoading();
                }
            });
            
            // Add the DataTable buttons to our custom container
            $('#exportButtons').append($('.dt-buttons'));
            
            // Handle search form submission
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                
                // Add active keyword filter tag if search has a value
                if ($('#searchKeywords').val()) {
                    addFilterTag('keyword', $('#searchKeywords').val());
                } else {
                    removeFilterTag('keyword');
                }
                
                // Add active year filter tag if year has a value
                if ($('#yearFilter').val()) {
                    addFilterTag('year', $('#yearFilter').val());
                } else {
                    removeFilterTag('year');
                }
                
                // Show filter results banner if any filters are active
                updateFilterBanner();
                
                // Reload the table with new search parameters
                showLoading();
                table.ajax.reload();
            });
            
            // Handle course filter chip clicks
            $('.filter-chip[data-filter="course"]').on('click', function() {
                // Update UI
                $('.filter-chip[data-filter="course"]').removeClass('active');
                $(this).addClass('active');
                
                // Get the filter value
                var value = $(this).data('value');
                
                // Add or remove course filter tag
                if (value !== 'all') {
                    addFilterTag('course', value);
                } else {
                    removeFilterTag('course');
                }
                
                // Update filter banner
                updateFilterBanner();
                
                // Reload table
                showLoading();
                table.ajax.reload();
            });
            
            // Handle design filter chip clicks
            $('.filter-chip[data-filter="design"]').on('click', function() {
                // Update UI
                $('.filter-chip[data-filter="design"]').removeClass('active');
                $(this).addClass('active');
                
                // Get the filter value
                var value = $(this).data('value');
                
                // Add or remove design filter tag
                if (value !== 'all') {
                    addFilterTag('design', value);
                } else {
                    removeFilterTag('design');
                }
                
                // Update filter banner
                updateFilterBanner();
                
                // Reload table
                showLoading();
                table.ajax.reload();
            });
            
            // Handle category filter button clicks
            $('.category-filter-btn').on('click', function() {
                var course = $(this).data('course');
                
                // Scroll to browse section
                $('html, body').animate({
                    scrollTop: $('#browse').offset().top - 100
                }, 500);
                
                // Activate the corresponding course filter
                $('.filter-chip[data-filter="course"]').removeClass('active');
                $('.filter-chip[data-filter="course"][data-value="' + course + '"]').addClass('active');
                
                // Add filter tag
                addFilterTag('course', course);
                
                // Update filter banner
                updateFilterBanner();
                
                // Reload table
                showLoading();
                table.ajax.reload();
            });
            
            // Handle advanced filter application
            $('#applyAdvancedFilters').on('click', function() {
                // Add filter tags for each active advanced filter
                if ($('#researchTypeFilter').val()) {
                    addFilterTag('type', $('#researchTypeFilter').val());
                } else {
                    removeFilterTag('type');
                }
                
                if ($('#researchDesignFilter').val()) {
                    // Also update the design filter chips UI
                    $('.filter-chip[data-filter="design"]').removeClass('active');
                    if ($('#researchDesignFilter').val() === '') {
                        $('.filter-chip[data-filter="design"][data-value="all"]').addClass('active');
                        removeFilterTag('design');
                    } else {
                        $('.filter-chip[data-filter="design"][data-value="' + $('#researchDesignFilter').val() + '"]').addClass('active');
                        addFilterTag('design', $('#researchDesignFilter').val());
                    }
                }
                
                if ($('#courseFilter').val()) {
                    // Also update the course filter chips UI
                    $('.filter-chip[data-filter="course"]').removeClass('active');
                    if ($('#courseFilter').val() === '') {
                        $('.filter-chip[data-filter="course"][data-value="all"]').addClass('active');
                        removeFilterTag('course');
                    } else {
                        $('.filter-chip[data-filter="course"][data-value="' + $('#courseFilter').val() + '"]').addClass('active');
                        addFilterTag('course', $('#courseFilter').val());
                    }
                }
                
                if ($('#respondentsFilter').val()) {
                    addFilterTag('respondents', $('#respondentsFilter').val());
                } else {
                    removeFilterTag('respondents');
                }
                
                // Update filter banner
                updateFilterBanner();
                
                // Close the accordion
                $('#collapseAdvancedFilter').collapse('hide');
                
                // Reload table
                showLoading();
                table.ajax.reload();
            });
            
            // Function to add filter tag
            function addFilterTag(type, value) {
                // Remove any existing filter of the same type
                removeFilterTag(type);
                
                // Add the new filter tag
                var icon = '';
                var typeName = '';
                
                switch (type) {
                    case 'keyword':
                        icon = 'fa-search';
                        typeName = 'Search';
                        break;
                    case 'year':
                        icon = 'fa-calendar';
                        typeName = 'Year';
                        break;
                    case 'course':
                        icon = 'fa-graduation-cap';
                        typeName = 'Program';
                        break;
                    case 'design':
                        icon = 'fa-flask';
                        typeName = 'Design';
                        break;
                    case 'type':
                        icon = 'fa-cogs';
                        typeName = 'Type';
                        break;
                    case 'respondents':
                        icon = 'fa-users';
                        typeName = 'Respondents';
                        break;
                }
                
                var tagHtml = '<span class="filter-tag" data-type="' + type + '">' +
                    '<i class="fas ' + icon + '"></i> ' + typeName + ': ' + value +
                    ' <button class="btn-close btn-close-white ms-2" style="font-size: 0.65em" onclick="removeFilterTagAndReload(\'' + type + '\')"></button>' +
                    '</span>';
                
                $('#activeFilters').append(tagHtml);
            }
            
            // Function to remove filter tag
            function removeFilterTag(type) {
                $('.filter-tag[data-type="' + type + '"]').remove();
            }
            
            // Function to update filter banner visibility
            function updateFilterBanner() {
                if ($('.filter-tag').length > 0) {
                    $('#filterResultsBanner').show();
                } else {
                    $('#filterResultsBanner').hide();
                }
            }
            
            // Handle clear all filters button
            $('#clearAllFilters').on('click', function() {
                // Clear all filter tags
                $('#activeFilters').empty();
                
                // Reset search and filter controls
                $('#searchKeywords').val('');
                $('#yearFilter').val('');
                $('#researchTypeFilter').val('');
                $('#researchDesignFilter').val('');
                $('#courseFilter').val('');
                $('#respondentsFilter').val('');
                
                // Reset filter chips
                $('.filter-chip[data-filter="course"]').removeClass('active');
                $('.filter-chip[data-filter="course"][data-value="all"]').addClass('active');
                $('.filter-chip[data-filter="design"]').removeClass('active');
                $('.filter-chip[data-filter="design"][data-value="all"]').addClass('active');
                
                // Hide filter banner
                $('#filterResultsBanner').hide();
                
                // Reload table
                showLoading();
                table.ajax.reload();
            });
            
            // Toggle columns visibility
            $('#toggleColumns').on('click', function() {
                // Toggle visibility of non-essential columns
                var column2 = table.column(2); // Researchers
                var column3 = table.column(3); // Adviser
                var column5 = table.column(5); // Research Design
                var column6 = table.column(6); // Research Type
                var column7 = table.column(7); // Respondents
                
                column2.visible(!column2.visible());
                column3.visible(!column3.visible());
                column5.visible(!column5.visible());
                
                // Toggle research type and respondents columns
                if (!column6.visible() && !column7.visible()) {
                    column6.visible(true);
                    column7.visible(true);
                } else {
                    column6.visible(false);
                    column7.visible(false);
                }
            });
            
            // View button click handler
            $(document).on('click', '.view-btn', function() {
                var id = $(this).data('id');
                
                // Show loading
                showLoading();
                
                // Fetch research details via AJAX
                $.ajax({
                    url: '/api/research/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Populate modal with research details
                        $('#paperTitle').text(data.title);
                        $('#paperCourse').text(data.course).removeClass().addClass('badge badge-course badge-' + data.course.toLowerCase());
                        $('#paperResearchers').text(data.researchers);
                        $('#paperAdviser').text(data.adviser);
                        $('#paperYear').text(data.year);
                        $('#paperMethodology').text(data.research_design || 'Not specified');
                        $('#paperType').text(data.research_type || 'Not specified');
                        $('#paperRespondents').text(data.respondents_count || 'Not specified');
                        $('#paperAbstract').text(data.abstract);
                        
                        // Process keywords
                        var keywords = data.keywords ? data.keywords.split(',') : [];
                        var keywordsHtml = '';
                        
                        keywords.forEach(function(keyword) {
                            keywordsHtml += '<span class="badge">' + keyword.trim() + '</span>';
                        });
                        
                        $('#paperKeywords').html(keywordsHtml || '<p>No keywords specified</p>');
                        
                        // Set download button link
                        if (data.file_path) {
                            $('#downloadPaperBtn').attr('href', '/api/research/' + data.id + '/download').removeClass('disabled');
                        } else {
                            $('#downloadPaperBtn').attr('href', '#').addClass('disabled');
                        }
                        
                        // Hide loading and show the modal
                        hideLoading();
                        $('#researchModal').modal('show');
                    },
                    error: function() {
                        hideLoading();
                        alert('Error fetching research details');
                    }
                });
            });
            
            // Load initial statistics
            loadStatistics();
            
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                var target = $(this.hash);
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 500);
                }
            });
            
            // Navbar active state based on scroll position
            $(window).on('scroll', function() {
                var scrollDistance = $(window).scrollTop();
                
                // Add/remove .active class to nav items based on scroll position
                $('section').each(function(i) {
                    if ($(this).position().top <= scrollDistance + 200) {
                        $('.navbar-nav a.active').removeClass('active');
                        $('.navbar-nav a').eq(i).addClass('active');
                    }
                });
                
                // Add background to navbar on scroll
                if (scrollDistance > 50) {
                    $('.navbar').addClass('shadow-sm');
                } else {
                    $('.navbar').removeClass('shadow-sm');
                }
            });
        });
        
        // Global function to remove filter tag and reload the table
        // This needs to be in the global scope to be called from inline onclick handlers
        function removeFilterTagAndReload(type) {
            // Remove the tag
            $('.filter-tag[data-type="' + type + '"]').remove();
            
            // Reset the corresponding filter control
            switch (type) {
                case 'keyword':
                    $('#searchKeywords').val('');
                    break;
                case 'year':
                    $('#yearFilter').val('');
                    break;
                case 'course':
                    $('.filter-chip[data-filter="course"]').removeClass('active');
                    $('.filter-chip[data-filter="course"][data-value="all"]').addClass('active');
                    $('#courseFilter').val('');
                    break;
                case 'design':
                    $('.filter-chip[data-filter="design"]').removeClass('active');
                    $('.filter-chip[data-filter="design"][data-value="all"]').addClass('active');
                    $('#researchDesignFilter').val('');
                    break;
                case 'type':
                    $('#researchTypeFilter').val('');
                    break;
                case 'respondents':
                    $('#respondentsFilter').val('');
                    break;
            }
            
            // Update filter banner
            if ($('.filter-tag').length === 0) {
                $('#filterResultsBanner').hide();
            }
            
            // Show loading overlay
            $('#loadingOverlay').addClass('show');
            
            // Reload the table
            $('#researchTable').DataTable().ajax.reload();
        }
    </script>
</body>
</html>

