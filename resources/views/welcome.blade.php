<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Academic Research Repository - Browse research papers across various disciplines">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilar-Archive</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
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
            scroll-behavior: smooth;
        }
        
    /* Enhanced Navbar Styles */
    .navbar {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
    }
    
    .navbar-brand {
        font-weight: 700;
        color: var(--primary-dark);
        transition: transform 0.3s;
    }
    
    .navbar-brand:hover {
        transform: translateY(-2px);
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
    }
    
    .nav-link {
        font-weight: 500;
        color: var(--gray-800);
        position: relative;
        margin: 0 0.5rem;
        padding: 0.5rem 0.75rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .nav-link:hover {
        color: var(--primary);
        background-color: rgba(67, 97, 238, 0.05);
    }
    
    .nav-link.active {
        color: var(--primary);
        background-color: rgba(67, 97, 238, 0.08);
    }
    
    .nav-link.btn {
        padding: 0.5rem 1rem;
        transition: all 0.3s;
    }
    
    .nav-link.btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
    }
    .dropdown-menu {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 1rem 0;
    }
    
    .dropdown-item {
        padding: 0.5rem 1.5rem;
        transition: all 0.2s;
    }
    
    .dropdown-item:hover {
        background-color: rgba(67, 97, 238, 0.08);
        transform: translateX(5px);
    }
    
    .dropdown-header {
        color: var(--primary);
        font-weight: 600;
        padding: 0.5rem 1.5rem;
    }
    @keyframes slideIn {
        0% {
            transform: translateY(1rem);
            opacity: 0;
        }
        100% {
            transform: translateY(0rem);
            opacity: 1;
        }
    }
    
    .slideIn {
        animation-name: slideIn;
        animation-duration: 0.3s;
        animation-fill-mode: both;
    }
    
    /* Mobile optimizations */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .nav-link {
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
        }
        
        .dropdown-menu {
            box-shadow: none;
            padding: 0;
            margin: 0 1rem;
        }
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
    position: relative;
    padding-right: 30px; /* Make room for the checkmark */
}

.filter-chip.active::after {
    content: "\f00c"; /* Font Awesome check icon */
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 0.8rem;
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
            width: 100%;
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
            cursor: pointer;
        }
        
        #researchTable tbody td {
            vertical-align: middle;
            padding: 15px;
            border-top: none;
            border-bottom: 1px solid var(--gray-200);
        }

        #researchTable tbody tr.no-results td {
            padding: 3rem 1rem;
            text-align: center;
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
        
        .badge-undefined, .badge-default {
            background-color: var(--gray-800);
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
            height: 100%;
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
            color: var(--primary);
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
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }
        
        .paper-meta i {
            color: var(--primary);
            margin-right: 10px;
            width: 20px;
            text-align: center;
            margin-top: 3px;
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

        #activeFilters {
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
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
        
        /* Loading indicator */
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
            transition: all 0.3s;
        }
        
        .loading-overlay.active {
            visibility: visible;
            opacity: 1;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Custom DataTables Styling */
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
        
        /* Empty state styling */
        .empty-state {
            text-align: center;
            padding: 2rem;
        }
        
        .empty-state-icon {
            font-size: 3rem;
            color: var(--gray-300);
            margin-bottom: 1rem;
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
            
            .filter-chips {
                justify-content: center;
            }
            
            .filter-chip {
                font-size: 0.8rem;
                padding: 6px 12px;
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
        
        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <!-- Back to Top Button -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Navigation -->
    <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <!-- Logo and Branding -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('pilarLogo.png') }}" alt="Pilar College" class="me-2" style="height: 2em; width: auto;">
            <span class="d-none d-sm-inline">Pilar College Research Repository</span>
            <span class="d-inline d-sm-none">Research Repository</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#"><i class="fas fa-home me-1"></i> Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#browse" id="browseDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-search me-1"></i> Browse
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="browseDropdown">
                        <li><a class="dropdown-item" href="#browse"><i class="fas fa-list-ul me-2"></i>All Research</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Programs</h6></li>
                        @foreach($courseCounts as $index => $courseCount)
                            @if($index < 5)
                                <li><a class="dropdown-item browse-by-course" href="#browse" data-course="{{ $courseCount->course }}">{{ $courseCount->course }}</a></li>
                            @endif
                        @endforeach
                        <li><a class="dropdown-item text-primary" href="#categories"><i class="fas fa-th-large me-2"></i>View All Programs</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#statistics"><i class="fas fa-chart-bar me-1"></i> Statistics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#categories"><i class="fas fa-th-large me-1"></i> Categories</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="{{ route('guest.research.enter_code') }}"><i class="fas fa-edit me-1"></i> Enter Research</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary btn-sm text-white ms-lg-3 mt-2 mt-lg-0 px-3" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </li>
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
                        
                        <form id="searchForm" autocomplete="off">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text border-0">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control border-0" id="searchKeywords" placeholder="Search by title, keywords, or abstract..." maxlength="100">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="yearFilter">
                                        <option value="">All Years</option>
                                        @foreach($years as $year)
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
                        
                        <!-- Filter Pills -->
                        <div class="filter-section">
                            <p class="fw-bold mb-2">Program/Course:</p>
                            <div class="filter-chips" id="courseFilters">
                                <button class="filter-chip active" data-filter="course" data-value="all">All Courses</button>
                                @foreach($courseCounts as $courseCount)
                                    <button class="filter-chip" data-filter="course" data-value="{{ $courseCount->course }}">{{ $courseCount->course }}</button>
                                @endforeach
                            </div>
                            
                            <p class="fw-bold mb-2 mt-3">Research Design:</p>
                            <div class="filter-chips" id="designFilters">
                                <button class="filter-chip active" data-filter="design" data-value="all">All Designs</button>
                                @foreach($researchDesigns as $design)
                                    <button class="filter-chip" data-filter="design" data-value="{{ $design }}">{{ $design }}</button>
                                @endforeach
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
                <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="table-container">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="m-0 fw-bold">Research Database</h3>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm rounded-pill" id="toggleColumns">
                                    <i class="fas fa-columns me-1"></i> Toggle Columns
                                </button>
                                
                            </div>
                        </div>
                        
                        <div id="filterSummary"></div>
                        
                        <div class="table-responsive">
                            <table id="researchTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Researchers</th>
                                        <th>Adviser</th>
                                        <th>Year</th>
                                        <th>Research Design</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($researchPapers as $paper)
                                    <tr>
                                        <td>{{ $paper->title }}</td>
                                        <td><span class="badge badge-course badge-{{ strtolower($paper->course) }}">{{ $paper->course }}</span></td>
                                        <td>{{ $paper->researchers }}</td>
                                        <td>{{ $paper->adviser }}</td>
                                        <td>{{ $paper->year }}</td>
                                        <td>{{ $paper->research_design ?? 'Not specified' }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm btn-action view-btn" data-id="{{ $paper->id }}">
                                                <i class="fas fa-eye me-1"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistics" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Research Statistics</h2>
                <p class="text-muted">Explore our repository's metrics and growth</p>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <div class="stats-card">
                        <div class="stats-icon stats-icon-research">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stats-count" id="totalPapers">{{ $stats['totalPapers'] }}</div>
                        <p class="text-muted mb-0">Total Research Papers</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="stats-card">
                        <div class="stats-icon stats-icon-researchers">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-count" id="totalResearchers">{{ $stats['totalResearchers'] }}</div>
                        <p class="text-muted mb-0">Researchers</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <div class="stats-card">
                        <div class="stats-icon stats-icon-advisers">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stats-count" id="totalAdvisers">{{ $stats['totalAdvisers'] }}</div>
                        <p class="text-muted mb-0">Faculty Advisers</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="stats-card">
                        <div class="stats-icon stats-icon-programs">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="stats-count" id="totalPrograms">{{ $stats['totalPrograms'] }}</div>
                        <p class="text-muted mb-0">Academic Programs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categories Section -->
    <section id="categories" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Browse by Category</h2>
                <p class="text-muted">Discover research papers by academic discipline</p>
            </div>
            
            <div class="row">
                @php $icons = [
                    'BSN' => 'fa-heartbeat',
                    'BSCS' => 'fa-laptop-code',
                    'BSIT' => 'fa-code',
                    'STEM' => 'fa-flask',
                    'HUMMS' => 'fa-users',
                    'ABM' => 'fa-chart-line'
                ]; @endphp
                
                @foreach($courseCounts as $index => $courseCount)
                    @if($index < 6)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="category-card">
                            <div class="card-body text-center p-4">
                                <div class="category-icon mx-auto">
                                    <i class="fas {{ $icons[$courseCount->course] ?? 'fa-book' }}"></i>
                                </div>
                                <h4 class="category-title">{{ $courseCount->course }}</h4>
                                <p class="category-description">Research studies focused on {{ $courseCount->course }} program exploring various methodologies and outcomes.</p>
                                <a href="#browse" class="btn btn-primary btn-modern browse-by-course" data-course="{{ $courseCount->course }}">
                                    Browse {{ $courseCount->paper_count }} Papers
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            
            <div class="text-center mt-4">
                <a href="#browse" class="btn btn-outline-primary btn-modern" id="viewAllCategories">
                    <i class="fas fa-th-large me-2"></i> View All Categories
                </a>
            </div>
        </div>
    </section>

    <!-- Research View Modal -->
    <div class="modal fade" id="researchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Research Paper Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="paper-details">
                        <div class="paper-header">
                            <h4 class="paper-title" id="paperTitle"></h4>
                            <div class="badge badge-course" id="paperCourse"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="paper-meta">
                                    <i class="fas fa-users"></i>
                                    <div>
                                        <small class="text-muted d-block">Researchers</small>
                                        <span id="paperResearchers"></span>
                                    </div>
                                </div>
                                
                                <div class="paper-meta">
                                    <i class="fas fa-user-tie"></i>
                                    <div>
                                        <small class="text-muted d-block">Adviser</small>
                                        <span id="paperAdviser"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="paper-meta">
                                    <i class="fas fa-calendar-alt"></i>
                                    <div>
                                        <small class="text-muted d-block">Year</small>
                                        <span id="paperYear"></span>
                                    </div>
                                </div>
                                
                                <div class="paper-meta">
                                    <i class="fas fa-flask"></i>
                                    <div>
                                        <small class="text-muted d-block">Methodology</small>
                                        <span id="paperMethodology"></span>
                                    </div>
                                </div>
                                
                                <div class="paper-meta">
                                    <i class="fas fa-users"></i>
                                    <div>
                                        <small class="text-muted d-block">Respondents</small>
                                        <span id="paperRespondents"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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
                    
                </div>
            </div>
        </div>
    </div>

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
                        @foreach($courseCounts as $index => $courseCount)
                            @if($index < 5)
                                <li><a href="#browse" class="browse-by-course" data-course="{{ $courseCount->course }}">{{ $courseCount->course }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>Contact Us</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>R. T. Lim Boulevard, Zamboanga City</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>(062) 991 5410</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>research@pilarcollege.edu.ph</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-md-0">© {{ date('Y') }} Pilar College Research Repository. All rights reserved.</p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <!-- Custom JavaScript -->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Avoid jQuery's document ready to fix counterUp issue
    // Initialize AOS animations
    AOS.init({
        once: true,
        offset: 100,
        duration: 800,
        disable: 'mobile'
    });
    
    // Set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Initialize DataTable with performance improvements
    var table = $('#researchTable').DataTable({
        responsive: true,
        ordering: true,
        paging: true,
        lengthChange: true,
        info: true,
        autoWidth: false,
        processing: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records...",
            lengthMenu: "_MENU_ records per page",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            infoEmpty: "No records available",
            infoFiltered: "(filtered from _MAX_ total records)",
            zeroRecords: "No matching records found",
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        },
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        columnDefs: [
            { targets: 6, orderable: false },
            { targets: [2, 3, 5], visible: true }
        ],
        initComplete: function() {
            // After table initialization
            $('.dataTables_wrapper .dataTables_filter input')
                .off()
                .on('input', debounce(function() {
                    table.search(this.value).draw();
                }, 500));
        }
    });
    
    // Debounce function for search input
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
    
    // STATISTICS SECTION - Simple counter function without plugins
    function animateCounter(element, target, duration) {
        if (!element) return;
        
        let start = 0;
        const increment = Math.ceil(target / (duration / 16));
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = start.toLocaleString();
            }
        }, 16);
    }
    
    // Animate counters when they come into view
    const counters = document.querySelectorAll('.stats-count');
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.textContent.replace(/,/g, ''));
                animateCounter(entry.target, target, 2000);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
    
    // Function to update filter indicator
    function updateFilterIndicator() {
        let activeFilters = [];
        
        // Check active course
        const activeCourse = $('.filter-chip[data-filter="course"].active').data('value');
        if (activeCourse && activeCourse !== 'all') {
            activeFilters.push('<span class="badge bg-primary me-2">Course: ' + activeCourse + '</span>');
        }
        
        // Check active design
        const activeDesign = $('.filter-chip[data-filter="design"].active').data('value');
        if (activeDesign && activeDesign !== 'all') {
            activeFilters.push('<span class="badge bg-info me-2">Design: ' + activeDesign + '</span>');
        }
        
        // Check year filter
        const yearFilter = $('#yearFilter').val();
        if (yearFilter) {
            activeFilters.push('<span class="badge bg-secondary me-2">Year: ' + yearFilter + '</span>');
        }
        
        // Check search keywords
        const keywords = $('#searchKeywords').val();
        if (keywords) {
            activeFilters.push('<span class="badge bg-dark me-2">Search: ' + sanitizeHTML(keywords) + '</span>');
        }
        
        // Update indicator
        if (activeFilters.length > 0) {
            $('#filterSummary').html(`
                <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                    <i class="fas fa-filter me-2"></i>
                    <div class="d-flex flex-wrap">
                        ${activeFilters.join('')}
                    </div>
                    <button type="button" class="btn-close ms-auto" id="clearFilters" aria-label="Clear filters"></button>
                </div>
            `);
        } else {
            $('#filterSummary').empty();
        }
    }
    
    // Sanitize HTML to prevent XSS
    function sanitizeHTML(str) {
        const temp = document.createElement('div');
        temp.textContent = str;
        return temp.innerHTML;
    }
    
    // Course filter functionality
    $('#courseFilters').on('click', '.filter-chip', function() {
        const value = $(this).data('value');
        
        // Update UI
        $('#courseFilters .filter-chip').removeClass('active');
        $(this).addClass('active');
        
        // Apply filter with a loading indicator
        showLoading();
        
        setTimeout(() => {
            if (value === 'all') {
                table.column(1).search('').draw();
            } else {
                table.column(1).search(value).draw();
            }
            
            // Update filter indicator
            updateFilterIndicator();
            hideLoading();
        }, 100);
    });
    
    // Research Design filter functionality
    $('#designFilters').on('click', '.filter-chip', function() {
        const value = $(this).data('value');
        
        // Update UI
        $('#designFilters .filter-chip').removeClass('active');
        $(this).addClass('active');
        
        // Apply filter with a loading indicator
        showLoading();
        
        setTimeout(() => {
            if (value === 'all') {
                table.column(5).search('').draw();
            } else {
                table.column(5).search(value).draw();
            }
            
            // Update filter indicator
            updateFilterIndicator();
            hideLoading();
        }, 100);
    });
    
    // Search form submission with throttling
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        
        showLoading();
        
        // Get form values with sanitization
        const keywords = sanitizeInput($('#searchKeywords').val());
        const year = $('#yearFilter').val();
        
        setTimeout(() => {
            // Apply search
            table.search(keywords).column(4).search(year).draw();
            
            // Update filter indicator
            updateFilterIndicator();
            hideLoading();
        }, 100);
    });
    
    // Input sanitization function
    function sanitizeInput(input) {
        if (!input) return '';
        // Remove HTML tags and limit length
        return input.replace(/<[^>]*>/g, '').substring(0, 100);
    }
    
    // Course category browsing functionality
    $('.browse-by-course').on('click', function(e) {
        e.preventDefault();
        
        // Get the course value
        const course = $(this).data('course');
        
        // Scroll to the browse section with smooth animation
        $('html, body').animate({
            scrollTop: $('#browse').offset().top - 100
        }, 500, function() {
            // After scrolling, apply the filter
            showLoading();
            
            setTimeout(() => {
                // Reset other filters first
                $('#designFilters .filter-chip').removeClass('active');
                $('#designFilters .filter-chip[data-value="all"]').addClass('active');
                
                // Now set the course filter
                $('#courseFilters .filter-chip').removeClass('active');
                $('#courseFilters .filter-chip[data-value="' + course + '"]').addClass('active');
                
                // Clear any existing search
                $('#searchKeywords').val('');
                $('#yearFilter').val('');
                
                // Apply filters to DataTable
                table
                    .search('')
                    .column(5).search('')
                    .column(1).search(course)
                    .draw();
                
                // Update search box placeholder
                $('#searchKeywords').attr('placeholder', 'Search within ' + course + ' papers...');
                
                // Update filter indicator
                updateFilterIndicator();
                hideLoading();
            }, 200);
        });
    });
    
    // View All Categories button
    $('#viewAllCategories').on('click', function(e) {
        e.preventDefault();
        
        // Scroll to the browse section
        $('html, body').animate({
            scrollTop: $('#browse').offset().top - 100
        }, 500, function() {
            // After scrolling, reset all filters
            showLoading();
            
            setTimeout(() => {
                // Reset all filters
                $('#courseFilters .filter-chip').removeClass('active');
                $('#courseFilters .filter-chip[data-value="all"]').addClass('active');
                
                $('#designFilters .filter-chip').removeClass('active');
                $('#designFilters .filter-chip[data-value="all"]').addClass('active');
                
                // Clear search and year filter
                $('#searchKeywords').val('').attr('placeholder', 'Search by title, keywords, or abstract...');
                $('#yearFilter').val('');
                
                // Reset DataTable search and draw
                table.search('').columns().search('').draw();
                
                // Update filter indicator
                updateFilterIndicator();
                hideLoading();
            }, 200);
        });
    });
    
    // Clear filters button
    $(document).on('click', '#clearFilters', function() {
        showLoading();
        
        setTimeout(() => {
            // Reset course filters
            $('#courseFilters .filter-chip').removeClass('active');
            $('#courseFilters .filter-chip[data-value="all"]').addClass('active');
            
            // Reset design filters
            $('#designFilters .filter-chip').removeClass('active');
            $('#designFilters .filter-chip[data-value="all"]').addClass('active');
            
            // Clear search and year filter
            $('#searchKeywords').val('').attr('placeholder', 'Search by title, keywords, or abstract...');
            $('#yearFilter').val('');
            
            // Reset DataTable search and draw
            table.search('').columns().search('').draw();
            
            // Remove filter indicator
            $('#filterSummary').empty();
            hideLoading();
        }, 100);
    });
    
    // Toggle columns visibility
    $('#toggleColumns').on('click', function() {
        // Toggle visibility of columns 2 (Researchers), 3 (Adviser), and 5 (Research Design)
        const column2 = table.column(2);
        const column3 = table.column(3);
        const column5 = table.column(5);
        
        // Get current visibility state
        const visible = column2.visible();
        
        // Toggle all columns
        column2.visible(!visible);
        column3.visible(!visible);
        column5.visible(!visible);
        
        // Update button text
        $(this).html(visible ? 
            '<i class="fas fa-columns me-1"></i> Show Details' : 
            '<i class="fas fa-columns me-1"></i> Hide Details');
    });
    
    // View button click handler with improved error handling
    $(document).on('click', '.view-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const id = $(this).data('id');
        
        // Show loading
        showLoading();
        
        // Fetch research details via AJAX
        $.ajax({
            url: '/research/' + id,
            type: 'GET',
            dataType: 'json',
            timeout: 10000, // 10-second timeout
            success: function(data) {
                // Hide loading
                hideLoading();
                
                // Populate modal with research details (with sanitization)
                $('#paperTitle').text(data.title || 'No Title');
                
                // Handle course badge
                const courseLower = (data.course || 'default').toLowerCase();
                $('#paperCourse')
                    .text(data.course || 'Unknown')
                    .removeClass()
                    .addClass('badge badge-course badge-' + courseLower);
                
                $('#paperResearchers').text(data.researchers || 'Not specified');
                $('#paperAdviser').text(data.adviser || 'Not specified');
                $('#paperYear').text(data.year || 'Not specified');
                $('#paperMethodology').text(data.research_design || 'Not specified');
                $('#paperRespondents').text(data.respondents_count || 'Not specified');
                $('#paperAbstract').text(data.abstract || 'No abstract available');
                
                // Process keywords
                let keywordsHtml = '';
                if (data.keywords) {
                    const keywords = data.keywords.split(',');
                    keywords.forEach(function(keyword) {
                        keywordsHtml += '<span class="badge">' + keyword.trim() + '</span>';
                    });
                }
                
                $('#paperKeywords').html(keywordsHtml || '<p>No keywords specified</p>');
                
              
                // Show the modal
                $('#researchModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle errors
                hideLoading();
                console.error('Error fetching research details:', error);
                
                // Show user-friendly error message
                alert('Sorry, there was a problem loading the research details. Please try again.');
            }
        });
    });
    
    // Make entire table row clickable to view research details
    $('#researchTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if we clicked on a button or control
        if ($(e.target).closest('button, a, input, select').length === 0) {
            $(this).find('.view-btn').trigger('click');
        }
    });
    
    // Loading indicator functions
    function showLoading() {
        $('#loadingOverlay').addClass('active');
    }
    
    function hideLoading() {
        $('#loadingOverlay').removeClass('active');
    }
    
    // Handle empty results with better UX
    table.on('draw', function() {
        if ($(table.table().body()).find('td.dataTables_empty').length) {
            $(table.table().body()).find('td.dataTables_empty').html(`
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h5>No matching research papers found</h5>
                    <p class="text-muted">Try adjusting your search criteria or filters</p>
                    <button class="btn btn-outline-primary btn-sm mt-3" id="resetFilters">
                        <i class="fas fa-undo me-1"></i> Reset Filters
                    </button>
                </div>
            `);
        }
    });
    
    // Reset filters from empty state
    $(document).on('click', '#resetFilters', function() {
        $('#clearFilters').trigger('click');
    });
    
    // Export functionality
    $('#exportCSV').on('click', function(e) {
        e.preventDefault();
        
        // Get current search/filter state
        const searchVal = table.search();
        const courseVal = table.column(1).search();
        const yearVal = table.column(4).search();
        const designVal = table.column(5).search();
        
        // Build export URL with current filters
        let url = '/api/research/export?format=csv';
        if (searchVal) url += '&search=' + encodeURIComponent(searchVal);
        if (courseVal) url += '&course=' + encodeURIComponent(courseVal);
        if (yearVal) url += '&year=' + encodeURIComponent(yearVal);
        if (designVal) url += '&design=' + encodeURIComponent(designVal);
        
        // Redirect to export endpoint
        window.location.href = url;
    });
    
    $('#exportPDF').on('click', function(e) {
        e.preventDefault();
        
        // Get current search/filter state
        const searchVal = table.search();
        const courseVal = table.column(1).search();
        const yearVal = table.column(4).search();
        const designVal = table.column(5).search();
        
        // Build export URL with current filters
        let url = '/api/research/export?format=pdf';
        if (searchVal) url += '&search=' + encodeURIComponent(searchVal);
        if (courseVal) url += '&course=' + encodeURIComponent(courseVal);
        if (yearVal) url += '&year=' + encodeURIComponent(yearVal);
        if (designVal) url += '&design=' + encodeURIComponent(designVal);
        
        // Redirect to export endpoint
        window.location.href = url;
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            if (this.getAttribute('href') !== '#') {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    
    // Navbar active state based on scroll position
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');
    
    window.addEventListener('scroll', function() {
        const scrollY = window.pageYOffset;
        
        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            const sectionTop = current.offsetTop - 150;
            const sectionId = current.getAttribute('id');
            
            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + sectionId) {
                        link.classList.add('active');
                    }
                });
            }
        });
        
        // Add background to navbar on scroll
        const navbar = document.querySelector('.navbar');
        if (scrollY > 50) {
            navbar.classList.add('shadow-sm');
        } else {
            navbar.classList.remove('shadow-sm');
        }
        
        // Show/hide back to top button
        const backToTop = document.getElementById('backToTop');
        if (scrollY > 300) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });
    
    // Back to top button functionality
    document.getElementById('backToTop').addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Add touch detection
    document.documentElement.classList.add(('ontouchstart' in window) ? 'touch' : 'no-touch');
    
    // Ensure proper Bootstrap dropdown behavior
    document.querySelectorAll('.dropdown-toggle').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.closest('.dropdown');
            
            document.querySelectorAll('.dropdown.show').forEach(function(el) {
                if (el !== dropdown) el.classList.remove('show');
            });
            
            dropdown.classList.toggle('show');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown.show').forEach(function(el) {
                el.classList.remove('show');
            });
        }
    });
    
    // Handle window resize for responsive tables
    window.addEventListener('resize', function() {
        if (table) {
            table.columns.adjust().responsive.recalc();
        }
    });
    
    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    popoverTriggerList.forEach(function(popoverTriggerEl) {
        new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Lazy load images for performance
    document.addEventListener('DOMContentLoaded', function() {
        const lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));
        
        if ('IntersectionObserver' in window) {
            const lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const lazyImage = entry.target;
                        lazyImage.src = lazyImage.dataset.src;
                        lazyImage.classList.remove('lazy');
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });
            
            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        }
    });
});
    </script>
</body>
</html>