<?php

namespace App\Http\Controllers;

use App\Models\Research;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Determine the view folder prefix based on the new Role names
        // Super Admin uses 'head' views, Research Staff uses 'user' views
        $prefix = Auth::user()->hasRole('Super Admin') ? 'head' : 'user';
    
        // Total counts
        $totalResearchPapers = Research::count();
        $totalUsers = User::count();
    
        // Get unique programs/courses
        $totalPrograms = Research::distinct('course')->count('course');
    
        // Research type counts
        $researchTypeCounts = Research::groupBy('research_type')
            ->select('research_type', DB::raw('count(*) as count'))
            ->pluck('count', 'research_type');
    
        // Course distribution
        $courseCounts = Research::groupBy('course')
            ->select('course', DB::raw('count(*) as count'))
            ->pluck('count', 'course');
    
        // Research design distribution
        $researchDesignCounts = Research::groupBy('research_design')
            ->select('research_design', DB::raw('count(*) as count'))
            ->pluck('count', 'research_design');
    
        // Total unique research types
        $totalResearchTypes = $researchTypeCounts->count();
    
        // Fetch users with their roles
        $users = User::with('roles')->get();
    
        // Fetch recent research papers
        $recentResearchPapers = Research::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    
        return view("{$prefix}.dashboard", compact(
            'totalResearchPapers', 
            'totalUsers', 
            'totalPrograms', 
            'totalResearchTypes',
            'courseCounts',
            'researchTypeCounts',
            'researchDesignCounts',
            'users',
            'recentResearchPapers'
        ));
    }
}