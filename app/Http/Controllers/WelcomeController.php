<?php

namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class WelcomeController extends Controller
{
   public function index()
    {
        // Fetch ONLY approved research papers
        $researchPapers = Research::where('approval_status', 'approved')->latest()->take(20)->get();
        
        // Get statistics based ONLY on approved papers
        $stats = [
            'totalPapers' => Research::where('approval_status', 'approved')->count(),
            'totalResearchers' => DB::table('researches')->where('approval_status', 'approved')->select('researchers')->distinct()->count(),
            'totalAdvisers' => DB::table('researches')->where('approval_status', 'approved')->select('adviser')->distinct()->count(),
            'totalPrograms' => DB::table('researches')->where('approval_status', 'approved')->select('course')->distinct()->count()
        ];
        
        // Get course counts based ONLY on approved papers
        $courseCounts = DB::table('researches')->where('approval_status', 'approved')
            ->select('course', DB::raw('count(*) as paper_count'))
            ->groupBy('course')->orderBy('paper_count', 'desc')->get();
            
        // Get available years from ONLY approved papers
        $years = DB::table('researches')->where('approval_status', 'approved')
            ->select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
            
        // Get available research designs from ONLY approved papers
        $researchDesigns = DB::table('researches')->where('approval_status', 'approved')
            ->select('research_design')->distinct()->whereNotNull('research_design')->pluck('research_design');
        
        return view('welcome', compact('researchPapers', 'stats', 'courseCounts', 'years', 'researchDesigns'));
    }
    
    /**
     * Process the DataTable AJAX request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResearchData(Request $request)
    {
        $query = Research::where('approval_status', 'approved')->select('*');

        // Apply filters
        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where(function($q) use ($keywords) {
                $q->where('title', 'LIKE', "%{$keywords}%")
                  ->orWhere('abstract', 'LIKE', "%{$keywords}%")
                  ->orWhere('keywords', 'LIKE', "%{$keywords}%");
            });
        }

        if ($request->has('year') && !empty($request->year)) {
            $query->where('year', $request->year);
        }

        if ($request->has('course') && $request->course !== 'all' && !empty($request->course)) {
            $query->where('course', $request->course);
        }

        if ($request->has('design') && $request->design !== 'all' && !empty($request->design)) {
            $query->where('research_design', $request->design);
        }

        if ($request->has('research_type') && !empty($request->research_type)) {
            $query->where('research_type', $request->research_type);
        }

        if ($request->has('respondents') && !empty($request->respondents)) {
            switch ($request->respondents) {
                case '1-50':
                    $query->whereBetween('respondents_count', [1, 50]);
                    break;
                case '51-100':
                    $query->whereBetween('respondents_count', [51, 100]);
                    break;
                case '101-200':
                    $query->whereBetween('respondents_count', [101, 200]);
                    break;
                case '201+':
                    $query->where('respondents_count', '>', 200);
                    break;
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Get a specific research paper details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResearchDetails($id)
    {
        // Find ONLY an approved paper by ID
        $research = Research::where('approval_status', 'approved')->findOrFail($id);
        return response()->json($research);
    }
    /**
     * Download a research paper file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadResearch($id)
    {
        // Find ONLY an approved paper to allow download
        $research = Research::where('approval_status', 'approved')->findOrFail($id);
        
        if (empty($research->file_path) || !Storage::disk('public')->exists($research->file_path)) {
            abort(404, 'File not found');
        }
        
        return Storage::disk('public')->download(
            $research->file_path, 
            $research->title . ' - ' . $research->year . '.pdf'
        );
    }

    /**
     * Get research statistics for dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
  public function getStatistics()
    {
        // Base query for approved papers
        $approvedQuery = Research::where('approval_status', 'approved');

        $totalPapers = $approvedQuery->count();
        
        // Calculations remain the same, but are now based on the approved query
        $researchersData = $approvedQuery->select('researchers')->get();
        $uniqueResearchers = collect();
        foreach ($researchersData as $research) {
            $names = explode(',', $research->researchers);
            foreach ($names as $name) {
                $uniqueResearchers->push(trim($name));
            }
        }
        $totalResearchers = $uniqueResearchers->unique()->count();
        
        $totalAdvisers = $approvedQuery->distinct()->whereNotNull('adviser')->count('adviser');
        $totalPrograms = $approvedQuery->distinct()->whereNotNull('course')->count('course');
        
        $programStats = $approvedQuery->select('course', DB::raw('count(*) as count'))
            ->groupBy('course')->whereNotNull('course')->get();
        
        $designStats = $approvedQuery->select('research_design', DB::raw('count(*) as count'))
            ->groupBy('research_design')->whereNotNull('research_design')->get();
        
        return response()->json([
            'totalPapers' => $totalPapers,
            'totalResearchers' => $totalResearchers,
            'totalAdvisers' => $totalAdvisers,
            'totalPrograms' => $totalPrograms,
            'programStats' => $programStats,
            'designStats' => $designStats
        ]);
    }
}
