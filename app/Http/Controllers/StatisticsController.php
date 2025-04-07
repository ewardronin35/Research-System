<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Research;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

// Custom PDF class based on TCPDF (similar to ResearchController)
class ReportPDF extends \TCPDF {
    public function Header() {
        // Add watermark first (so it appears behind text)
        $watermarkPath = public_path('pilarLogo.png');
        if (file_exists($watermarkPath)) {
            // Get page width and height
            $pageWidth = $this->getPageWidth();
            $pageHeight = $this->getPageHeight();
            
            // Calculate the center position and size for the watermark
            $watermarkWidth = 150;
            $watermarkHeight = 150;
            $watermarkX = ($pageWidth - $watermarkWidth) / 2;
            $watermarkY = ($pageHeight - $watermarkHeight) / 2;
            
            // Add the watermark with transparency
            $this->SetAlpha(0.1); // 10% opacity for watermark
            $this->Image($watermarkPath, $watermarkX, $watermarkY, $watermarkWidth, $watermarkHeight, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
            $this->SetAlpha(1); // Reset opacity for rest of content
        }
        
        // Left logo
        $leftLogoPath = public_path('pilarLogo.png');
        if (file_exists($leftLogoPath)) {
            $this->Image($leftLogoPath, 15, 10, 20, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        // Right logo
        $rightLogoPath = public_path('Research.png');
        if (file_exists($rightLogoPath)) {
            $this->Image($rightLogoPath, 175, 10, 20, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        // Header content - Use Times for the main title (as closest to Times New Roman)
        $this->SetY(10);
        $this->SetX(15);
        $this->SetFont('times', 'B', 14);
        $this->Cell(180, 6, 'PILAR COLLEGE OF ZAMBOANGA CITY, INC.', 0, 1, 'C');
        
        // Address and Phone - Helvetica 12 (closest to Calibri)
        $this->SetX(15);
        $this->SetFont('helvetica', '', 12);
        $this->Cell(180, 6, 'R. T. Lim Boulevard, Zamboanga City', 0, 1, 'C');
        $this->SetX(15);
        $this->Cell(180, 6, 'Tel. No. (062) 991 5410', 0, 1, 'C');
        
        // Move down a bit more to avoid colliding with the logo
        $this->Ln(5);
        
        // Draw violet line
        $this->SetDrawColor(128, 0, 128); // RGB values for violet
        $this->SetLineWidth(0.7); // Thicker line
        $currentY = $this->GetY();
        $this->Line(15, $currentY, 195, $currentY);
        
        // Reset line color to black for rest of document
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.2); // Reset to normal line width
        
        // Add extra space after line
        $this->Ln(5);
    }
    
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

class StatisticsController extends Controller
{
    /**
     * Display the statistics dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $prefix = Auth::user()->hasRole('head') ? 'head' : 'user';

        // Get all research papers
        $researches = Research::all();
        
        // Calculate basic statistics
        $stats = [
            'totalPapers' => $researches->count(),
            'publishedThisYear' => $researches->where('year', date('Y'))->count(),
            'totalResearchers' => $this->countUniqueResearchers($researches),
            'totalAdvisers' => $researches->pluck('adviser')->unique()->count(),
        ];
        
        // Research by Course Data
        $courseData = DB::table('researches')
            ->select('course', DB::raw('count(*) as count'))
            ->groupBy('course')
            ->orderBy('count', 'desc')
            ->get();
        
        // Research by Year Data
        $yearData = DB::table('researches')
            ->select('year', DB::raw('count(*) as count'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        
        // Research by Methodology Data
        $methodologyData = DB::table('researches')
            ->select('research_design', DB::raw('count(*) as count'))
            ->groupBy('research_design')
            ->orderBy('count', 'desc')
            ->get();
        
        // Research by Category Data
        $categoryData = DB::table('researches')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
        
        return view("{$prefix}.statistics.index", compact(
            'researches', 
            'stats', 
            'courseData', 
            'yearData', 
            'methodologyData', 
            'categoryData'
        ));
    }

    /**
     * Display the reports page.
     *
     * @return \Illuminate\View\View
     */
    public function reports()
    {
        $prefix = Auth::user()->hasRole('head') ? 'head' : 'user';
        
        // Get all research papers
        $researches = Research::all();
        
        // Research by Course Data
        $courseData = DB::table('researches')
            ->select('course', DB::raw('count(*) as count'))
            ->groupBy('course')
            ->orderBy('count', 'desc')
            ->get();
        
        // Research by Year Data
        $yearData = DB::table('researches')
            ->select('year', DB::raw('count(*) as count'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        
        // Research by Methodology Data
        $methodologyData = DB::table('researches')
            ->select('research_design', DB::raw('count(*) as count'))
            ->groupBy('research_design')
            ->orderBy('count', 'desc')
            ->get();
        
        // Research by Category Data
        $categoryData = DB::table('researches')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
            
        return view("{$prefix}.statistics.reports", compact(
            'researches',
            'courseData', 
            'yearData', 
            'methodologyData', 
            'categoryData'
        ));
    }

    /**
     * Display the visualizations page.
     *
     * @return \Illuminate\View\View
     */
    public function visualizations()
    {
        $prefix = Auth::user()->hasRole('head') ? 'head' : 'user';
        
        // Get all research papers
        $researches = Research::all();
        
        // Calculate basic statistics
        $stats = [
            'totalPapers' => $researches->count(),
            'publishedThisYear' => $researches->where('year', date('Y'))->count(),
            'totalResearchers' => $this->countUniqueResearchers($researches),
            'totalAdvisers' => $researches->pluck('adviser')->unique()->count(),
        ];
        
        // Research by Course Data
        $courseData = DB::table('researches')
            ->select('course', DB::raw('count(*) as count'))
            ->groupBy('course')
            ->orderBy('count', 'desc')
            ->get();
        
        // Research by Year Data
        $yearData = DB::table('researches')
            ->select('year', DB::raw('count(*) as count'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        
        // Research by Methodology Data
        $methodologyData = DB::table('researches')
            ->select('research_design', DB::raw('count(*) as count'))
            ->groupBy('research_design')
            ->orderBy('count', 'desc')
            ->get();
        
        // Research by Category Data
        $categoryData = DB::table('researches')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
        
        return view("{$prefix}.statistics.visualizations", compact(
            'researches', 
            'stats', 
            'courseData', 
            'yearData', 
            'methodologyData', 
            'categoryData'
        ));
    }

    /**
     * Export data as CSV file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCsv(Request $request)
    {
        $type = $request->input('type', 'all');
        
        switch ($type) {
            case 'course':
                return $this->exportCourseStats();
            case 'year':
                return $this->exportYearStats();
            case 'methodology':
                return $this->exportMethodologyStats();
            case 'category':
                return $this->exportCategoryStats();
            default:
                return $this->exportAllResearch();
        }
    }

    /**
     * Export research by course statistics.
     *
     * @return \Illuminate\Http\Response
     */
    private function exportCourseStats()
    {
        $courseData = DB::table('researches')
            ->select('course', DB::raw('count(*) as count'))
            ->groupBy('course')
            ->orderBy('count', 'desc')
            ->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="research_by_course.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($courseData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Course', 'Number of Papers']);
            
            foreach ($courseData as $row) {
                fputcsv($file, [$row->course ?: 'Not Specified', $row->count]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Export research by year statistics.
     *
     * @return \Illuminate\Http\Response
     */
    private function exportYearStats()
    {
        $yearData = DB::table('researches')
            ->select('year', DB::raw('count(*) as count'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="research_by_year.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($yearData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Year', 'Number of Papers']);
            
            foreach ($yearData as $row) {
                fputcsv($file, [$row->year, $row->count]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export research by methodology statistics.
     *
     * @return \Illuminate\Http\Response
     */
    private function exportMethodologyStats()
    {
        $methodologyData = DB::table('researches')
            ->select('research_design', DB::raw('count(*) as count'))
            ->groupBy('research_design')
            ->orderBy('count', 'desc')
            ->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="research_by_methodology.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($methodologyData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Research Design', 'Number of Papers']);
            
            foreach ($methodologyData as $row) {
                fputcsv($file, [$row->research_design ?: 'Not Specified', $row->count]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export research by category statistics.
     *
     * @return \Illuminate\Http\Response
     */
    private function exportCategoryStats()
    {
        $categoryData = DB::table('researches')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="research_by_category.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($categoryData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Category', 'Number of Papers']);
            
            foreach ($categoryData as $row) {
                fputcsv($file, [$row->category ?: 'Not Specified', $row->count]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export all research papers data.
     *
     * @return \Illuminate\Http\Response
     */
    private function exportAllResearch()
    {
        $researches = Research::all();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="all_research.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($researches) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 
                'Title', 
                'Course', 
                'Researchers', 
                'Adviser', 
                'Year', 
                'Category', 
                'Program', 
                'Research Design', 
                'Research Type', 
                'Respondents Count', 
                'Abstract', 
                'Keywords'
            ]);
            
            foreach ($researches as $research) {
                fputcsv($file, [
                    $research->id,
                    $research->title,
                    $research->course,
                    $research->researchers,
                    $research->adviser,
                    $research->year,
                    $research->category,
                    $research->program,
                    $research->research_design,
                    $research->research_type,
                    $research->respondents_count,
                    $research->abstract,
                    $research->keywords
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Count unique researchers from research papers.
     * 
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @return int
     */
    private function countUniqueResearchers($researches)
    {
        $uniqueResearchers = collect();
        
        foreach ($researches as $research) {
            $researchers = explode(',', $research->researchers);
            foreach ($researchers as $researcher) {
                $researcher = trim($researcher);
                if (!empty($researcher) && !$uniqueResearchers->contains($researcher)) {
                    $uniqueResearchers->push($researcher);
                }
            }
        }
        
        return $uniqueResearchers->count();
    }

    /**
     * Generate a report based on request parameters.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateReport(Request $request)
    {
        try {
            // Log the request for debugging
            Log::info('Report generation request', [
                'params' => $request->all(),
                'url' => $request->fullUrl()
            ]);
            
            // Determine the report type
            $type = $request->input('type', 'all');
            $format = $request->input('format', 'pdf');
            
            // Set report title based on type
            $reportTitle = match($type) {
                'course' => 'Research Papers by Course',
                'year' => 'Research Papers by Year',
                'methodology' => 'Research Papers by Methodology',
                'adviser' => 'Research Papers by Adviser',
                'abstract' => 'Research Papers with Abstracts',
                default => 'Complete Research Report',
            };
            
            // Custom report name if provided
            if ($request->has('report_name') && !empty($request->report_name)) {
                $reportTitle = $request->report_name;
            }
            
            // Build query with filters
            $query = Research::query();
            
            // Apply course filter
            if ($request->has('course') && !empty($request->course)) {
                if (is_array($request->course)) {
                    $query->whereIn('course', $request->course);
                } else {
                    $query->where('course', $request->course);
                }
            }
            
            // Apply year range filter
            if ($request->has('year_start') && !empty($request->year_start)) {
                $query->where('year', '>=', $request->year_start);
            }
            
            if ($request->has('year_end') && !empty($request->year_end)) {
                $query->where('year', '<=', $request->year_end);
            }
            
            // Apply research design filter
            if ($request->has('research_design') && !empty($request->research_design)) {
                if (is_array($request->research_design)) {
                    $query->whereIn('research_design', $request->research_design);
                } else {
                    $query->where('research_design', $request->research_design);
                }
            }
            
            // Apply category filter
            if ($request->has('category') && !empty($request->category)) {
                if (is_array($request->category)) {
                    $query->whereIn('category', $request->category);
                } else {
                    $query->where('category', $request->category);
                }
            }
            
            // Apply ordering and set fields based on report type
            switch ($type) {
                case 'course':
                    // Course-specific report
                    $query->orderBy('course')->orderBy('year', 'desc');
                    if (!$request->has('fields')) {
                        $request->merge(['fields' => ['title', 'course', 'year', 'researchers', 'adviser']]);
                    }
                    break;
                    
                case 'methodology':
                    // Methodology-specific report  
                    $query->orderBy('research_design')->orderBy('research_type');
                    if (!$request->has('fields')) {
                        $request->merge(['fields' => ['title', 'research_design', 'research_type', 'year', 'course', 'respondents_count']]);
                    }
                    break;
                    
                case 'adviser':
                    // Adviser-specific report
                    $query->orderBy('adviser')->orderBy('year', 'desc');
                    if (!$request->has('fields')) {
                        $request->merge(['fields' => ['title', 'adviser', 'course', 'year', 'researchers']]);
                    }
                    break;
                    
                case 'year':
                    // Year-specific report
                    $query->orderBy('year', 'desc')->orderBy('course');
                    if (!$request->has('fields')) {
                        $request->merge(['fields' => ['title', 'year', 'course', 'research_design', 'researchers']]);
                    }
                    break;
                    
                case 'abstract':
                    // Report with abstracts
                    $query->orderBy('year', 'desc');
                    if (!$request->has('fields')) {
                        $request->merge(['fields' => ['title', 'abstract', 'year', 'course', 'researchers']]);
                    }
                    break;
                    
                case 'all':
                default:
                    // Full report with all basic fields
                    $query->orderBy('year', 'desc')->orderBy('title');
                    if (!$request->has('fields')) {
                        $request->merge(['fields' => ['title', 'course', 'researchers', 'adviser', 'year', 'research_design']]);
                    }
                    break;
            }
            
            // Get results
            $researches = $query->get();
            
            Log::info('Found research papers', ['count' => $researches->count()]);
            
            // Generate report based on format
            switch ($format) {
                case 'csv':
                    return $this->generateEnhancedCsvReport($researches, $request, $type, $reportTitle);
                case 'excel':
                    return $this->generateEnhancedExcelReport($researches, $request, $type, $reportTitle);
                case 'pdf':
                default:
                    return $this->generateEnhancedPdfReport($researches, $request, $type, $reportTitle);
            }
        } catch (\Exception $e) {
            Log::error('Error generating report', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error generating report: ' . $e->getMessage());
        }
    }

    /**
     * Generate enhanced PDF report with proper styling.
     *
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     * @param string $type
     * @param string $reportTitle
     * @return \Illuminate\Http\Response
     */
    private function generateEnhancedPdfReport($researches, $request, $type, $reportTitle)
    {
        // Create new PDF document using custom class
        $pdf = new ReportPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Auth::user()->name);
        $pdf->SetTitle($reportTitle);
        $pdf->SetSubject('Research Statistics Report');
        $pdf->SetKeywords('Research, Statistics, ' . $type);
        
        // Set header and footer fonts
        $pdf->setHeaderFont(Array('times', 'B', 14));
        $pdf->setFooterFont(Array('helvetica', '', 8));
        
        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont('courier');
        
        // ADJUSTMENT: Increase margins for better visibility
        $pdf->SetMargins(15, 45, 15); // Increased top margin
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        
        // Set auto page breaks with more space at bottom
        $pdf->SetAutoPageBreak(TRUE, 20);
        
        // Add a page
        $pdf->AddPage();
        
        // Set font for title
        $pdf->SetFont('times', 'B', 16);
        
        // Add title and subtitle with styling
        $titleHtml = '
        <style>
            h1 {
                font-family: times;
                font-size: 16pt;
                font-weight: bold;
                text-align: center;
                color: #4b0082;
                margin-bottom: 5px;
            }
            h2 {
                font-family: helvetica;
                font-size: 12pt;
                text-align: center;
                margin-bottom: 15px;
                color: #555555;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
                margin-bottom: 15px;
            }
            th {
                background-color: #4b0082;
                color: white;
                font-weight: bold;
                padding: 5px;
                text-align: center;
            }
            td {
                padding: 5px;
                border: 1px solid #dddddd;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
        </style>
        
        <h1>' . htmlspecialchars($reportTitle) . '</h1>
        <h2>Generated on: ' . date('F d, Y') . ' by ' . htmlspecialchars(Auth::user()->name) . '</h2>';
        
        $pdf->writeHTML($titleHtml, true, false, true, false, '');
        
        // Generate content based on report type
        switch ($type) {
            case 'course':
                $this->generateEnhancedCourseReportContent($pdf, $researches, $request);
                break;
            case 'year':
                $this->generateEnhancedYearReportContent($pdf, $researches, $request);
                break;
            case 'methodology':
                $this->generateEnhancedMethodologyReportContent($pdf, $researches, $request);
                break;
            case 'adviser':
                $this->generateEnhancedAdviserReportContent($pdf, $researches, $request);
                break;
            case 'abstract':
                $this->generateEnhancedAbstractReportContent($pdf, $researches, $request);
                break;
            default:
                $this->generateEnhancedFullReportContent($pdf, $researches, $request);
                break;
        }
    
        // Close and output PDF document
        $pdfName = Str::slug($reportTitle) . '_' . date('YmdHis') . '.pdf';
        return $pdf->Output($pdfName, 'D');
    }

    /**
     * Generate enhanced CSV report with improved structure.
     *
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     * @param string $type
     * @param string $reportTitle
     * @return \Illuminate\Http\Response
     */
    private function generateEnhancedCsvReport($researches, $request, $type, $reportTitle)
    {
        // Selected fields for export
        $fields = $request->input('fields', ['title', 'course', 'researchers', 'adviser', 'year']);
        
        // Make sure $fields is always an array
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
        }
        
        // Clean report name for filename
        $filename = Str::slug($reportTitle) . '_' . date('YmdHis') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($researches, $fields, $reportTitle, $type) {
            $file = fopen('php://output', 'w');
            
            // IMPROVEMENT: More comprehensive header section with consistent formatting
            fputcsv($file, ["PILAR COLLEGE OF ZAMBOANGA CITY, INC."]);
            fputcsv($file, ["R. T. Lim Boulevard, Zamboanga City"]);
            fputcsv($file, ["Tel. No. (062) 991 5410"]);
            fputcsv($file, []);
            fputcsv($file, ["RESEARCH REPOSITORY REPORT"]);
            fputcsv($file, ["Report Type:", $reportTitle]);
            fputcsv($file, ["Generated on:", date('F d, Y h:i A')]);
            fputcsv($file, ["Generated by:", Auth::user()->name]);
            fputcsv($file, ["Total Records:", $researches->count()]);
            fputcsv($file, []);
            
            // IMPROVEMENT: Add report parameters section
            fputcsv($file, ["REPORT PARAMETERS"]);
            fputcsv($file, ["Report Type:", $type]);
            
            // Add type-specific parameters
            switch ($type) {
                case 'course':
                    if ($request->has('course') && !empty($request->course)) {
                        fputcsv($file, ["Course Filter:", is_array($request->course) ? implode(', ', $request->course) : $request->course]);
                    }
                    break;
                case 'year':
                    if ($request->has('year_start') && !empty($request->year_start)) {
                        fputcsv($file, ["Year Start:", $request->year_start]);
                    }
                    if ($request->has('year_end') && !empty($request->year_end)) {
                        fputcsv($file, ["Year End:", $request->year_end]);
                    }
                    break;
                case 'methodology':
                    if ($request->has('research_design') && !empty($request->research_design)) {
                        fputcsv($file, ["Research Design:", is_array($request->research_design) ? implode(', ', $request->research_design) : $request->research_design]);
                    }
                    break;
            }
            
            fputcsv($file, ["Report Fields:", implode(', ', $fields)]);
            fputcsv($file, []);
            
            // IMPROVEMENT: Add a section divider
            fputcsv($file, ["RESEARCH DATA"]);
            fputcsv($file, []);
            
            // Create header row with field labels
            $headerLabels = [
                'id' => 'ID',
                'title' => 'Title',
                'course' => 'Course',
                'researchers' => 'Researchers',
                'adviser' => 'Adviser',
                'year' => 'Year',
                'category' => 'Category',
                'program' => 'Program',
                'research_design' => 'Research Design',
                'research_type' => 'Research Type',
                'respondents_count' => 'Respondents Count',
                'abstract' => 'Abstract',
                'keywords' => 'Keywords'
            ];
            
            // IMPROVEMENT: Add serial number column
            $headers = ["No."];
            foreach ($fields as $field) {
                $headers[] = $headerLabels[$field] ?? ucfirst($field);
            }
            
            fputcsv($file, $headers);
            
            // Add data rows with row numbers
            $rowNumber = 1;
            foreach ($researches as $research) {
                $row = [$rowNumber++];
                foreach ($fields as $field) {
                    $row[] = $research->$field ?? '';
                }
                fputcsv($file, $row);
            }
            
            // IMPROVEMENT: Better structured summary section
            fputcsv($file, []);
            fputcsv($file, ["SUMMARY ANALYSIS"]);
            fputcsv($file, []);
            
            // Add summary based on report type
            switch ($type) {
                case 'course':
                    // Summary by course
                    fputcsv($file, ["Course Distribution"]);
                    fputcsv($file, ["Course", "Count", "Percentage", "Year Range"]);
                    
                    $courseSummary = $researches->groupBy('course')
                        ->map(function ($group) use ($researches) {
                            return [
                                'count' => $group->count(),
                                'percentage' => round(($group->count() / $researches->count()) * 100, 2),
                                'min_year' => $group->min('year'),
                                'max_year' => $group->max('year')
                            ];
                        })->sortByDesc('count');
                    
                    foreach ($courseSummary as $course => $data) {
                        fputcsv($file, [
                            $course ?: 'Not Specified',
                            $data['count'],
                            $data['percentage'] . '%',
                            $data['min_year'] . ' - ' . $data['max_year']
                        ]);
                    }
                    break;
                
                case 'year':
                    // Summary by year with improved stats
                    fputcsv($file, ["Year Distribution"]);
                    fputcsv($file, ["Year", "Count", "Percentage", "Courses", "Avg. Researchers"]);
                    
                    $yearSummary = $researches->groupBy('year')
                        ->map(function ($group) use ($researches) {
                            // Calculate average researchers per paper
                            $avgResearchers = $group->map(function($paper) {
                                $researchers = explode(',', $paper->researchers);
                                return count(array_filter($researchers));
                            })->average();
                            
                            return [
                                'count' => $group->count(),
                                'percentage' => round(($group->count() / $researches->count()) * 100, 2),
                                'courses' => $group->pluck('course')->unique()->count(),
                                'avg_researchers' => round($avgResearchers, 1)
                            ];
                        })->sortKeysDesc();
                    
                    foreach ($yearSummary as $year => $data) {
                        fputcsv($file, [
                            $year,
                            $data['count'],
                            $data['percentage'] . '%',
                            $data['courses'],
                            $data['avg_researchers']
                        ]);
                    }
                    break;
                
                case 'methodology':
                    // Summary by research design with research types
                    fputcsv($file, ["Research Design Distribution"]);
                    fputcsv($file, ["Research Design", "Count", "Percentage", "Research Types"]);
                    
                    $designSummary = $researches->groupBy('research_design')
                        ->map(function ($group) use ($researches) {
                            // Get unique research types for this design
                            $types = $group->pluck('research_type')->unique()->filter()->implode(', ');
                            
                            return [
                                'count' => $group->count(),
                                'percentage' => round(($group->count() / $researches->count()) * 100, 2),
                                'types' => $types ?: 'Not Specified'
                            ];
                        })->sortByDesc('count');
                    
                    foreach ($designSummary as $design => $data) {
                        fputcsv($file, [
                            $design ?: 'Not Specified',
                            $data['count'],
                            $data['percentage'] . '%',
                            $data['types']
                        ]);
                    }
                    break;
                
                default:
                    // Comprehensive summary for other report types
                    fputcsv($file, ["General Summary"]);
                    fputcsv($file, ["Total Papers:", $researches->count()]);
                    fputcsv($file, ["Year Range:", $researches->min('year') . ' - ' . $researches->max('year')]);
                    fputcsv($file, ["Unique Courses:", $researches->pluck('course')->unique()->count()]);
                    fputcsv($file, ["Unique Advisers:", $researches->pluck('adviser')->unique()->count()]);
                    
                    // Research design breakdown
                    fputcsv($file, []);
                    fputcsv($file, ["Research Design Breakdown"]);
                    $researchDesigns = $researches->groupBy('research_design')
                        ->map(function ($group) use ($researches) {
                            return [
                                'count' => $group->count(),
                                'percentage' => round(($group->count() / $researches->count()) * 100, 2)
                            ];
                        })->sortByDesc('count');
                    
                    fputcsv($file, ["Design", "Count", "Percentage"]);
                    foreach ($researchDesigns as $design => $data) {
                        fputcsv($file, [
                            $design ?: 'Not Specified',
                            $data['count'],
                            $data['percentage'] . '%'
                        ]);
                    }
                    break;
            }
            
            // IMPROVEMENT: Add report footer
            fputcsv($file, []);
            fputcsv($file, ["End of Report"]);
            fputcsv($file, ["Pilar College Research Repository - " . date('Y')]);
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate enhanced Excel report with proper styling.
     *
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     * @param string $type
     * @param string $reportTitle
     * @return \Illuminate\Http\Response
     */
    private function generateEnhancedExcelReport($researches, $request, $type, $reportTitle)
    {
        // Selected fields for export
        $fields = $request->input('fields', ['title', 'course', 'researchers', 'adviser', 'year']);
        
        // Make sure $fields is always an array
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
        }
        
        // Clean report name for filename
        $filename = Str::slug($reportTitle) . '_' . date('YmdHis') . '.xls';
        
        // Create Excel using CSV format with appropriate headers to force Excel download
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($researches, $fields, $reportTitle, $type, $request) {
            $file = fopen('php://output', 'w');
            
            // Add report header with formatting - Excel will render this as HTML
            fwrite($file, "<html>");
            fwrite($file, "<head>");
            fwrite($file, "<style>");
            fwrite($file, "
                .title { font-size: 16pt; font-weight: bold; text-align: center; }
                .subtitle { font-size: 12pt; text-align: center; }
                .header { font-weight: bold; background-color: #4b0082; color: white; }
                .subheader { font-weight: bold; background-color: #e6e6fa; }
                .centered { text-align: center; }
                .summary { font-weight: bold; }
            ");
            fwrite($file, "</style>");
            fwrite($file, "</head>");
            fwrite($file, "<body>");
            
            // Institution header
            fwrite($file, "<table border='0' width='100%'>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."' class='title'>PILAR COLLEGE OF ZAMBOANGA CITY, INC.</td></tr>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."' class='subtitle'>R. T. Lim Boulevard, Zamboanga City</td></tr>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."' class='subtitle'>Tel. No. (062) 991 5410</td></tr>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."'>&nbsp;</td></tr>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."' class='title'>$reportTitle</td></tr>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."' class='subtitle'>Generated on: " . date('F d, Y h:i A') . "</td></tr>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."' class='subtitle'>Generated by: " . Auth::user()->name . "</td></tr>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."' class='subtitle'>Total Records: " . $researches->count() . "</td></tr>");
            fwrite($file, "<tr><td colspan='". (count($fields) + 1) ."'>&nbsp;</td></tr>");
            fwrite($file, "</table>");
            
            // Start main data table
            fwrite($file, "<table border='1' width='100%'>");
            
            // Table header row
            fwrite($file, "<tr class='header'>");
            
            // Create header row with field labels
            $headerLabels = [
                'id' => 'ID',
                'title' => 'Title',
                'course' => 'Course',
                'researchers' => 'Researchers',
                'adviser' => 'Adviser',
                'year' => 'Year',
                'category' => 'Category',
                'program' => 'Program',
                'research_design' => 'Research Design',
                'research_type' => 'Research Type',
                'respondents_count' => 'Respondents Count',
                'abstract' => 'Abstract',
                'keywords' => 'Keywords'
            ];
            
            // Serial number column
            fwrite($file, "<th>No.</th>");
            
            foreach ($fields as $field) {
                fwrite($file, "<th>" . ($headerLabels[$field] ?? ucfirst($field)) . "</th>");
            }
            fwrite($file, "</tr>");
            
            // Add data rows
            $rowNumber = 1;
            foreach ($researches as $research) {
                fwrite($file, "<tr>");
                fwrite($file, "<td class='centered'>" . $rowNumber++ . "</td>");
                
                foreach ($fields as $field) {
                    $value = $research->$field ?? '';
                    
                    // Special formatting for certain fields
                    if ($field == 'abstract' && strlen($value) > 100) {
                        $value = substr($value, 0, 97) . '...';
                    }
                    
                    fwrite($file, "<td>" . htmlspecialchars($value) . "</td>");
                }
                fwrite($file, "</tr>");
            }
            
            fwrite($file, "</table>");
            
            // Add summary section based on report type
            fwrite($file, "<br><br>");
            fwrite($file, "<table border='1' width='60%'>");
            
            switch ($type) {
                case 'course':
                    // Summary by course
                    fwrite($file, "<tr><td colspan='3' class='subheader'>Course Breakdown</td></tr>");
                    fwrite($file, "<tr class='header'><th>Course</th><th>Count</th><th>Percentage</th></tr>");
                    
                    $courseSummary = $researches->groupBy('course')
                        ->map(function ($group) use ($researches) {
                            return [
                                'count' => $group->count(),
                                'percentage' => round(($group->count() / $researches->count()) * 100, 2)
                            ];
                        })->sortByDesc('count');
                    
                    foreach ($courseSummary as $course => $data) {
                        fwrite($file, "<tr>");
                        fwrite($file, "<td>" . ($course ?: 'Not Specified') . "</td>");
                        fwrite($file, "<td class='centered'>" . $data['count'] . "</td>");
                        fwrite($file, "<td class='centered'>" . $data['percentage'] . "%</td>");
                        fwrite($file, "</tr>");
                    }
                    break;
                
                case 'year':
                    // Summary by year
                    fwrite($file, "<tr><td colspan='3' class='subheader'>Year Breakdown</td></tr>");
                    fwrite($file, "<tr class='header'><th>Year</th><th>Count</th><th>Percentage</th></tr>");
                    
                    $yearSummary = $researches->groupBy('year')
                        ->map(function ($group) use ($researches) {
                            return [
                                'count' => $group->count(),
                                'percentage' => round(($group->count() / $researches->count()) * 100, 2)
                            ];
                        })->sortKeysDesc();
                    
                    foreach ($yearSummary as $year => $data) {
                        fwrite($file, "<tr>");
                        fwrite($file, "<td>" . $year . "</td>");
                        fwrite($file, "<td class='centered'>" . $data['count'] . "</td>");
                        fwrite($file, "<td class='centered'>" . $data['percentage'] . "%</td>");
                        fwrite($file, "</tr>");
                    }
                    break;
                
                case 'methodology':
                    // Summary by research design
                    fwrite($file, "<tr><td colspan='3' class='subheader'>Research Design Breakdown</td></tr>");
                    fwrite($file, "<tr class='header'><th>Research Design</th><th>Count</th><th>Percentage</th></tr>");
                    
                    $designSummary = $researches->groupBy('research_design')
                        ->map(function ($group) use ($researches) {
                            return [
                                'count' => $group->count(),
                                'percentage' => round(($group->count() / $researches->count()) * 100, 2)
                            ];
                        })->sortByDesc('count');
                    
                    foreach ($designSummary as $design => $data) {
                        fwrite($file, "<tr>");
                        fwrite($file, "<td>" . ($design ?: 'Not Specified') . "</td>");
                        fwrite($file, "<td class='centered'>" . $data['count'] . "</td>");
                        fwrite($file, "<td class='centered'>" . $data['percentage'] . "%</td>");
                        fwrite($file, "</tr>");
                    }
                    break;
                
                default:
                    // Simple summary for other report types
                    fwrite($file, "<tr><td colspan='2' class='subheader'>Summary</td></tr>");
                    fwrite($file, "<tr><td class='summary'>Total Papers:</td><td>" . $researches->count() . "</td></tr>");
                    break;
            }
            
            fwrite($file, "</table>");
            fwrite($file, "</body></html>");
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate enhanced content for course report in PDF.
     *
     * @param ReportPDF $pdf
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     */
    private function generateEnhancedCourseReportContent($pdf, $researches, $request)
    {
        // Overview section
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Course Distribution Overview', 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->Ln(2);
        
        // Group by course
        $courseData = $researches->groupBy('course')
            ->map(function ($group) {
                return $group->count();
            })->sortDesc();
        
        // Course distribution table
        $pdf->SetFillColor(75, 0, 130); // Indigo (matches PILAR color theme)
        $pdf->SetTextColor(255, 255, 255); // White text for header
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(100, 8, 'Course', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Number of Papers', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Percentage', 1, 1, 'C', true);
        
        // Reset text color to black for data rows
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        
        $totalPapers = $researches->count();
        $rowCount = 0;
        
        foreach ($courseData as $course => $count) {
            // Alternate row background color for better readability
            $fillColor = ($rowCount % 2 === 0) ? false : true;
            $fillColorValue = ($rowCount % 2 === 0) ? 255 : 240;
            $pdf->SetFillColor($fillColorValue, $fillColorValue, $fillColorValue);
            
            $pdf->Cell(90, 8, $course ?: 'Not Specified', 1, 0, 'L', $fillColor);
            $pdf->Cell(40, 8, $count, 1, 0, 'C', $fillColor);
            $pdf->Cell(40, 8, round(($count / $totalPapers) * 100, 1) . '%', 1, 1, 'C', $fillColor);
            
            $rowCount++;
        }
        
        // Add detailed list of papers by adviser
        $this->addDetailedResearchList($pdf, $researches, $request);
    }

    /**
     * Generate enhanced content for abstract report in PDF.
     *
     * @param ReportPDF $pdf
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     */
    private function generateEnhancedAbstractReportContent($pdf, $researches, $request)
    {
        // HTML content for abstracts with styling
        $html = '
        <style>
            h1 {
                font-family: times;
                font-size: 14pt;
                font-weight: bold;
                color: #4b0082;
                margin-top: 0;
                margin-bottom: 8px;
                border-bottom: 1px solid #4b0082;
                padding-bottom: 3px;
            }
            .label {
                font-weight: bold;
                display: inline-block;
                width: 100px;
            }
            .info {
                margin-bottom: 5px;
            }
            .abstract-section {
                margin-top: 10px;
                margin-bottom: 5px;
            }
            .abstract-title {
                font-weight: bold;
                font-size: 12pt;
                color: #4b0082;
                margin-bottom: 5px;
            }
            .abstract-content {
                text-align: justify;
                margin-bottom: 10px;
            }
            .keywords {
                font-style: italic;
                margin-bottom: 20px;
            }
            .divider {
                border-bottom: 1px dashed #cccccc;
                margin: 15px 0;
            }
        </style>';
        
        $count = 1;
        foreach ($researches as $paper) {
            if ($count > 1) {
                $html .= '<div class="divider"></div>';
            }
            
            $html .= '<h1>' . $count . '. ' . htmlspecialchars($paper->title) . '</h1>';
            
            $html .= '<div class="info"><span class="label">Course:</span> ' . htmlspecialchars($paper->course) . '</div>';
            $html .= '<div class="info"><span class="label">Year:</span> ' . htmlspecialchars($paper->year) . '</div>';
            $html .= '<div class="info"><span class="label">Researchers:</span> ' . htmlspecialchars($paper->researchers) . '</div>';
            $html .= '<div class="info"><span class="label">Adviser:</span> ' . htmlspecialchars($paper->adviser) . '</div>';
            
            if (!empty($paper->research_design)) {
                $html .= '<div class="info"><span class="label">Design:</span> ' . htmlspecialchars($paper->research_design);
                if (!empty($paper->research_type)) {
                    $html .= ' - ' . htmlspecialchars($paper->research_type);
                }
                $html .= '</div>';
            }
            
            if (!empty($paper->respondents_count)) {
                $html .= '<div class="info"><span class="label">Respondents:</span> ' . htmlspecialchars($paper->respondents_count) . '</div>';
            }
            
            $html .= '<div class="abstract-section">';
            $html .= '<div class="abstract-title">ABSTRACT</div>';
            $html .= '<div class="abstract-content">' . htmlspecialchars($paper->abstract ?: 'Abstract not available') . '</div>';
            $html .= '</div>';
            
            if (!empty($paper->keywords)) {
                $html .= '<div class="keywords"><span class="label">Keywords:</span> ' . htmlspecialchars($paper->keywords) . '</div>';
            }
            
            // Check if we need to add a page break (not for the last paper)
            if ($count < $researches->count()) {
                $html .= '<div style="page-break-after: always;"></div>';
            }
            
            $count++;
        }
        
        // Output HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    /**
     * Generate enhanced content for full report in PDF.
     *
     * @param ReportPDF $pdf
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     */
    private function generateEnhancedFullReportContent($pdf, $researches, $request)
    {
        // Get selected fields or use all available fields if there's an issue
        $allPossibleFields = [
            'id', 'title', 'course', 'researchers', 'adviser', 'year', 
            'abstract', 'keywords', 'program', 'category', 'research_design', 
            'research_type', 'respondents_count'
        ];
        
        $fields = $request->input('fields', ['title', 'course', 'researchers', 'adviser', 'year']);
        
        // Make sure $fields is always an array
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
        }
        
        // Add report statistics
        $statistics = '
        <style>
            .stats-container {
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 10px;
                margin-bottom: 20px;
            }
            .stats-title {
                font-weight: bold;
                font-size: 12pt;
                color: #4b0082;
                margin-bottom: 5px;
            }
            .stats-item {
                margin-bottom: 5px;
            }
            .stats-label {
                font-weight: bold;
                display: inline-block;
                width: 170px;
            }
            .stats-value {
                font-weight: bold;
                color: #4b0082;
            }
        </style>
        
        <div class="stats-container">
            <div class="stats-title">Report Statistics</div>
            <div class="stats-item">
                <span class="stats-label">Total Research Papers:</span>
                <span class="stats-value">' . $researches->count() . '</span>
            </div>
            <div class="stats-item">
                <span class="stats-label">Unique Courses:</span>
                <span class="stats-value">' . $researches->pluck('course')->unique()->count() . '</span>
            </div>
            <div class="stats-item">
                <span class="stats-label">Year Range:</span>
                <span class="stats-value">' . $researches->min('year') . ' - ' . $researches->max('year') . '</span>
            </div>
            <div class="stats-item">
                <span class="stats-label">Generated On:</span>
                <span class="stats-value">' . date('F d, Y h:i A') . '</span>
            </div>
        </div>';
        
        $pdf->writeHTML($statistics, true, false, true, false, '');
        
        // Use a completely HTML-based approach for better table rendering
        $html = '
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }
            th {
                background-color: #4b0082;
                color: white;
                font-weight: bold;
                padding: 4px;
                text-align: center;
                font-size: 9pt;
            }
            td {
                padding: 4px;
                font-size: 8pt;
                border: 1px solid #dddddd;
                word-wrap: break-word;
            }
            tr:nth-child(even) {
                background-color: #f5f5f5;
            }
            .centered {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
            thead {
                display: table-header-group;
            }
            tbody {
                display: table-row-group;
            }
        </style>';
        
        $html .= '<table border="1" cellpadding="2" cellspacing="0">';
        $html .= '<thead><tr><th width="5%">No.</th>';
        
        // Get field labels
        $headerLabels = [
            'id' => 'ID',
            'title' => 'Title',
            'course' => 'Course',
            'researchers' => 'Researchers',
            'adviser' => 'Adviser',
            'year' => 'Year',
            'category' => 'Category',
            'program' => 'Program',
            'research_design' => 'Research Design',
            'research_type' => 'Research Type',
            'respondents_count' => 'Respondents',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords'
        ];
        
        // Calculate column widths based on field type
        $remainingWidth = 95; // 95% after the 5% for No. column
        $columnCount = count($fields);
        
        // Predefined width ratios for different field types
        $fieldWidthRatios = [
            'title' => 3,
            'abstract' => 3,
            'researchers' => 2,
            'keywords' => 1.5,
            'adviser' => 1.5,
            'course' => 1.5,
            'research_design' => 1.5,
            'year' => 0.8,
            'category' => 1.2,
            'program' => 1.2,
            'research_type' => 1.5,
            'respondents_count' => 1,
            'id' => 0.8
        ];
        
        // Calculate total ratio
        $totalRatio = 0;
        foreach ($fields as $field) {
            $totalRatio += $fieldWidthRatios[$field] ?? 1;
        }
        
        // Calculate actual widths
        $fieldWidths = [];
        foreach ($fields as $field) {
            $ratio = $fieldWidthRatios[$field] ?? 1;
            $fieldWidths[$field] = round(($ratio / $totalRatio) * $remainingWidth, 1);
            $html .= '<th width="' . $fieldWidths[$field] . '%">' . ($headerLabels[$field] ?? ucfirst($field)) . '</th>';
        }
        
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        
        // Add data rows
        foreach ($researches as $index => $research) {
            $html .= '<tr>';
            $html .= '<td class="centered">' . ($index + 1) . '</td>';
            
            foreach ($fields as $field) {
                $value = $research->$field ?? '';
                
                // Truncate long text values appropriately for PDF display
                $maxLength = match($field) {
                    'title' => 80,
                    'abstract' => 100,
                    'researchers' => 60,
                    'keywords' => 40,
                    'research_design' => 40,
                    'adviser' => 40,
                    default => 30
                };
                
                if (strlen($value) > $maxLength) {
                    $value = substr($value, 0, $maxLength - 3) . '...';
                }
                
                // Center certain fields
                $class = in_array($field, ['year', 'respondents_count', 'id']) ? 'centered' : 'text-left';
                $html .= '<td class="' . $class . '">' . htmlspecialchars($value) . '</td>';
            }
            
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        
        // Output the HTML table
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Add a summary section
        $pdf->AddPage();
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Summary Analysis', 0, 1, 'L');
        
        // Create summaries for different categories using HTML for better rendering
        $this->addSummarySection($pdf, $researches, 'course', 'Course');
        $this->addSummarySection($pdf, $researches, 'year', 'Year');
        $this->addSummarySection($pdf, $researches, 'research_design', 'Research Design');
        
        if ($researches->whereNotNull('category')->count() > 0) {
            $this->addSummarySection($pdf, $researches, 'category', 'Category');
        }
    }
    
    /**
     * Add a summary section for a specific field in the PDF report.
     *
     * @param ReportPDF $pdf
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param string $field
     * @param string $label
     */
    private function addSummarySection($pdf, $researches, $field, $label)
    {
        // Group data by the specified field
        $groupedData = $researches->groupBy($field)
            ->map(function ($group) {
                return $group->count();
            })->sortDesc();
        
        if ($field == 'year') {
            // For year, sort chronologically
            $groupedData = $researches->groupBy($field)
                ->map(function ($group) {
                    return $group->count();
                })->sortKeys();
        }
        
        // Create HTML for the summary table
        $html = '
        <style>
            .summary-title {
                font-family: times;
                font-size: 12pt;
                font-weight: bold;
                margin-top: 15px;
                margin-bottom: 5px;
                color: #4b0082;
            }
            .summary-table {
                width: 80%;
                margin-left: auto;
                margin-right: auto;
                border-collapse: collapse;
            }
            .summary-table th {
                background-color: #4b0082;
                color: white;
                font-weight: bold;
                padding: 6px;
                text-align: center;
            }
            .summary-table td {
                padding: 5px;
                border: 1px solid #dddddd;
            }
            .summary-table tr:nth-child(even) {
                background-color: #f5f5f5;
            }
            .centered {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
        </style>
        
        <div class="summary-title">Distribution by ' . $label . '</div>
        <table class="summary-table" border="1">
            <thead>
                <tr>
                    <th width="60%">' . $label . '</th>
                    <th width="20%">Count</th>
                    <th width="20%">Percentage</th>
                </tr>
            </thead>
            <tbody>';
        
        $totalPapers = $researches->count();
        
        foreach ($groupedData as $value => $count) {
            $displayValue = $value ?: 'Not Specified';
            $percentage = round(($count / $totalPapers) * 100, 1);
            
            $html .= '<tr>';
            $html .= '<td class="text-left">' . htmlspecialchars($displayValue) . '</td>';
            $html .= '<td class="centered">' . $count . '</td>';
            $html .= '<td class="centered">' . $percentage . '%</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        
        // Output the HTML
        $pdf->writeHTML($html, true, false, true, false, '');
    }
    
    /**
     * Add a detailed list of research papers to the PDF.
     *
     * @param ReportPDF $pdf
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     */
    private function addDetailedResearchList($pdf, $researches, $request)
    {
        // Add a new page for the detailed list
        $pdf->AddPage();
        
        // Selected fields (ensure title is always included)
        $fields = $request->input('fields', ['title', 'course', 'researchers', 'adviser', 'year']);
        if (!in_array('title', $fields)) {
            array_unshift($fields, 'title');
        }
        
        // Make sure $fields is always an array
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
        }
        
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Detailed Research Papers List', 0, 1, 'L');
        $pdf->Ln(2);
        
        // Create HTML for the detailed table
        $html = '
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 5px;
                margin-bottom: 15px;
            }
            th {
                background-color: #4b0082;
                color: white;
                font-weight: bold;
                padding: 5px;
                text-align: center;
                font-size: 9pt;
            }
            td {
                padding: 5px;
                font-size: 8pt;
                border: 1px solid #dddddd;
                word-wrap: break-word;
            }
            tr:nth-child(even) {
                background-color: #f5f5f5;
            }
            .centered {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
            thead {
                display: table-header-group;
            }
            tbody {
                display: table-row-group;
            }
        </style>';
        
        $html .= '<table border="1" cellpadding="2" cellspacing="0">';
        $html .= '<thead><tr><th width="5%">No.</th>';
        
        // Get field labels
        $headerLabels = [
            'id' => 'ID',
            'title' => 'Title',
            'course' => 'Course',
            'researchers' => 'Researchers',
            'adviser' => 'Adviser',
            'year' => 'Year',
            'category' => 'Category',
            'program' => 'Program',
            'research_design' => 'Research Design',
            'research_type' => 'Research Type',
            'respondents_count' => 'Respondents',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords'
        ];
        
        // Calculate column widths based on field type
        $remainingWidth = 95; // 95% after the 5% for No. column
        $columnCount = count($fields);
        
        // Predefined width ratios for different field types
        $fieldWidthRatios = [
            'title' => 3,
            'abstract' => 3,
            'researchers' => 2,
            'keywords' => 1.5,
            'adviser' => 1.5,
            'course' => 1.5,
            'research_design' => 1.5,
            'year' => 0.8,
            'category' => 1.2,
            'program' => 1.2,
            'research_type' => 1.5,
            'respondents_count' => 1,
            'id' => 0.8
        ];
        
        // Calculate total ratio
        $totalRatio = 0;
        foreach ($fields as $field) {
            $totalRatio += $fieldWidthRatios[$field] ?? 1;
        }
        
        // Calculate actual widths
        $fieldWidths = [];
        foreach ($fields as $field) {
            $ratio = $fieldWidthRatios[$field] ?? 1;
            $fieldWidths[$field] = round(($ratio / $totalRatio) * $remainingWidth, 1);
            $html .= '<th width="' . $fieldWidths[$field] . '%">' . ($headerLabels[$field] ?? ucfirst($field)) . '</th>';
        }
        
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        
        // Add data rows
        foreach ($researches as $index => $research) {
            $html .= '<tr>';
            $html .= '<td class="centered">' . ($index + 1) . '</td>';
            
            foreach ($fields as $field) {
                $value = $research->$field ?? '';
                
                // Truncate long text values appropriately for PDF display
                $maxLength = match($field) {
                    'title' => 80,
                    'abstract' => 100,
                    'researchers' => 60,
                    'keywords' => 40,
                    'research_design' => 40,
                    'adviser' => 40,
                    default => 30
                };
                
                if (strlen($value) > $maxLength) {
                    $value = substr($value, 0, $maxLength - 3) . '...';
                }
                
                // Center certain fields
                $class = in_array($field, ['year', 'respondents_count', 'id']) ? 'centered' : 'text-left';
                $html .= '<td class="' . $class . '">' . htmlspecialchars($value) . '</td>';
            }
            
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        
        // Output the HTML
        $pdf->writeHTML($html, true, false, true, false, '');
    }
           
    /**
     * Generate enhanced content for year report in PDF.
     *
     * @param ReportPDF $pdf
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     */
    private function generateEnhancedYearReportContent($pdf, $researches, $request)
    {
        // Overview section
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Year Distribution Overview', 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->Ln(2);
        
        // Group by year
        $yearData = $researches->groupBy('year')
            ->map(function ($group) {
                return $group->count();
            })->sortKeys();
        
        // Year distribution table
        $pdf->SetFillColor(75, 0, 130); // Indigo (matches PILAR color theme)
        $pdf->SetTextColor(255, 255, 255); // White text for header
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(50, 8, 'Year', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Number of Papers', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Percentage', 1, 1, 'C', true);
        
        // Reset text color to black for data rows
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        
        $totalPapers = $researches->count();
        $rowCount = 0;
        
        foreach ($yearData as $year => $count) {
            // Alternate row background color for better readability
            $fillColor = ($rowCount % 2 === 0) ? false : true;
            $fillColorValue = ($rowCount % 2 === 0) ? 255 : 240;
            $pdf->SetFillColor($fillColorValue, $fillColorValue, $fillColorValue);
            
            $pdf->Cell(50, 8, $year, 1, 0, 'L', $fillColor);
            $pdf->Cell(50, 8, $count, 1, 0, 'C', $fillColor);
            $pdf->Cell(50, 8, round(($count / $totalPapers) * 100, 1) . '%', 1, 1, 'C', $fillColor);
            
            $rowCount++;
        }
        
        // Year trend analysis
        $pdf->Ln(5);
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Year Trend Analysis', 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        
        // Calculate year-over-year growth
        $previousCount = null;
        
        $pdf->Ln(2);
        $pdf->SetFillColor(75, 0, 130);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(50, 8, 'Year', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Number of Papers', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Growth %', 1, 1, 'C', true);
        
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        
        $rowCount = 0;
        foreach ($yearData as $year => $count) {
            $fillColor = ($rowCount % 2 === 0) ? false : true;
            $fillColorValue = ($rowCount % 2 === 0) ? 255 : 240;
            $pdf->SetFillColor($fillColorValue, $fillColorValue, $fillColorValue);
            
            $growth = '';
            if ($previousCount !== null && $previousCount > 0) {
                $growthPercent = round((($count - $previousCount) / $previousCount) * 100, 1);
                
                // Color code the growth percentage (green for positive, red for negative)
                if ($growthPercent > 0) {
                    $pdf->SetTextColor(0, 128, 0); // Green
                    $growth = '+' . $growthPercent . '%';
                } elseif ($growthPercent < 0) {
                    $pdf->SetTextColor(255, 0, 0); // Red
                    $growth = $growthPercent . '%';
                } else {
                    $pdf->SetTextColor(0, 0, 0); // Black
                    $growth = '0%';
                }
            } else {
                $pdf->SetTextColor(0, 0, 0); // Black
                $growth = 'N/A';
            }
            
            $pdf->Cell(50, 8, $year, 1, 0, 'L', $fillColor);
            $pdf->Cell(50, 8, $count, 1, 0, 'C', $fillColor);
            $pdf->Cell(50, 8, $growth, 1, 1, 'C', $fillColor);
            
            $previousCount = $count;
            $pdf->SetTextColor(0, 0, 0); // Reset text color
            $rowCount++;
        }
        
        // Add detailed list of papers by year
        $this->addDetailedResearchList($pdf, $researches, $request);
    }

    /**
     * Generate enhanced content for methodology report in PDF.
     *
     * @param ReportPDF $pdf
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     */
    private function generateEnhancedMethodologyReportContent($pdf, $researches, $request)
    {
        // Overview section
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Research Methodology Overview', 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->Ln(2);
        
        // Group by research design
        $methodologyData = $researches->groupBy('research_design')
            ->map(function ($group) {
                return $group->count();
            })->sortDesc();
        
        // Methodology distribution table
        $pdf->SetFillColor(75, 0, 130); // Indigo (matches PILAR color theme)
        $pdf->SetTextColor(255, 255, 255); // White text for header
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(90, 8, 'Research Design', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Number of Papers', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Percentage', 1, 1, 'C', true);
        
        // Reset text color to black for data rows
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        
        $totalPapers = $researches->count();
        $rowCount = 0;
        
        foreach ($methodologyData as $design => $count) {
            // Alternate row background color for better readability
            $fillColor = ($rowCount % 2 === 0) ? false : true;
            $fillColorValue = ($rowCount % 2 === 0) ? 255 : 240;
            $pdf->SetFillColor($fillColorValue, $fillColorValue, $fillColorValue);
            
            $pdf->Cell(90, 8, $design ?: 'Not Specified', 1, 0, 'L', $fillColor);
            $pdf->Cell(40, 8, $count, 1, 0, 'C', $fillColor);
            $pdf->Cell(40, 8, round(($count / $totalPapers) * 100, 1) . '%', 1, 1, 'C', $fillColor);
            
            $rowCount++;
        }
        
        // Research Types within each Research Design
        $pdf->AddPage();
        foreach ($methodologyData as $design => $count) {
            $designPapers = $researches->where('research_design', $design);
            
            // Group by research type
            $typeData = $designPapers->groupBy('research_type')
                ->map(function ($group) {
                    return $group->count();
                })->sortDesc();
            
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, ($design ?: 'Not Specified') . ' (' . $count . ' papers)', 0, 1, 'L');
            
            if ($typeData->count() > 0) {
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->SetFillColor(75, 0, 130);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->Cell(90, 8, 'Research Type', 1, 0, 'C', true);
                $pdf->Cell(40, 8, 'Count', 1, 0, 'C', true);
                $pdf->Cell(40, 8, 'Percentage', 1, 1, 'C', true);
                
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('helvetica', '', 10);
                
                $rowCount = 0;
                foreach ($typeData as $type => $typeCount) {
                    $fillColor = ($rowCount % 2 === 0) ? false : true;
                    $fillColorValue = ($rowCount % 2 === 0) ? 255 : 240;
                    $pdf->SetFillColor($fillColorValue, $fillColorValue, $fillColorValue);
                    
                    $pdf->Cell(90, 8, $type ?: 'Not Specified', 1, 0, 'L', $fillColor);
                    $pdf->Cell(40, 8, $typeCount, 1, 0, 'C', $fillColor);
                    $pdf->Cell(40, 8, round(($typeCount / $count) * 100, 1) . '%', 1, 1, 'C', $fillColor);
                    $rowCount++;
                }
                
                $pdf->Ln(5);
            }
        }
        
        // Add detailed list of papers by methodology
        $this->addDetailedResearchList($pdf, $researches, $request);
    }

    /**
     * Generate enhanced content for adviser report in PDF.
     *
     * @param ReportPDF $pdf
     * @param \Illuminate\Database\Eloquent\Collection $researches
     * @param \Illuminate\Http\Request $request
     */
    private function generateEnhancedAdviserReportContent($pdf, $researches, $request)
    {
        // Overview section
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Adviser Distribution Overview', 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->Ln(2);
        
        // Group by adviser
        $adviserData = $researches->groupBy('adviser')
            ->map(function ($group) {
                return $group->count();
            })->sortDesc();
        
        // Adviser distribution table
        $pdf->SetFillColor(75, 0, 130); // Indigo (matches PILAR color theme)
        $pdf->SetTextColor(255, 255, 255); // White text for header
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(90, 8, 'Adviser', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Number of Papers', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Percentage', 1, 1, 'C', true);
        
        // Reset text color to black for data rows
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        
        $totalPapers = $researches->count();
        $rowCount = 0;
        
        foreach ($adviserData as $adviser => $count) {
            $fillColor = ($rowCount % 2 === 0) ? false : true;
            $fillColorValue = ($rowCount % 2 === 0) ? 255 : 240;
            $pdf->SetFillColor($fillColorValue, $fillColorValue, $fillColorValue);
            
            $pdf->Cell(100, 8, $adviser ?: 'Not Specified', 1, 0, 'L', $fillColor);
            $pdf->Cell(40, 8, $count, 1, 0, 'C', $fillColor);
            $pdf->Cell(40, 8, round(($count / $totalPapers) * 100, 1) . '%', 1, 1, 'C', $fillColor);
            
            $rowCount++;
        }
        
        // Course breakdown by research design
        $pdf->AddPage();
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Course by Research Design', 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->Ln(2);
        
        // Create cross-tabulation
        $researchDesigns = $researches->pluck('research_design')->unique()->sort()->filter();
        
        // Header row
        $pdf->SetFillColor(75, 0, 130); // Indigo (matches PILAR color theme)
        $pdf->SetTextColor(255, 255, 255); // White text for header
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(60, 8, 'Course', 1, 0, 'C', true);
        
        foreach ($researchDesigns as $design) {
            $pdf->Cell(30, 8, $design ?: 'Not Specified', 1, 0, 'C', true);
        }
        
        $pdf->Cell(30, 8, 'Total', 1, 1, 'C', true);
        
        // Reset text color to black for data rows
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        
        $rowCount = 0;
        foreach ($courseData as $course => $totalCount) {
            // Alternate row background color
            $fillColor = ($rowCount % 2 === 0) ? false : true;
            $fillColorValue = ($rowCount % 2 === 0) ? 255 : 240;
            $pdf->SetFillColor($fillColorValue, $fillColorValue, $fillColorValue);
            
            $pdf->Cell(60, 8, $course ?: 'Not Specified', 1, 0, 'L', $fillColor);
            
            foreach ($researchDesigns as $design) {
                $count = $researches->where('course', $course)->where('research_design', $design)->count();
                $pdf->Cell(30, 8, $count, 1, 0, 'C', $fillColor);
            }
            
            $pdf->Cell(30, 8, $totalCount, 1, 1, 'C', $fillColor);
            $rowCount++;
        }
        
        // Add detailed list of papers by course
        $this->addDetailedResearchList($pdf, $researches, $request);
    }
}