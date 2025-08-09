<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Research;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Mail\ResearchStatusUpdated; 
use Illuminate\Support\Facades\Mail; 
use TCPDF;
class MYPDF extends TCPDF {
    public function Header() {
        // Add watermark first (so it appears behind text)
        $watermarkPath = public_path('pilarLogo.png');
        if (file_exists($watermarkPath)) {
            // Get page width and height
            $pageWidth = $this->getPageWidth();
            $pageHeight = $this->getPageHeight();
            
            // Calculate the center position and size for the watermark - make it bigger
            $watermarkWidth = 150; // Increased from 100
            $watermarkHeight = 150; // Increased from 100
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
        // PILAR COLLEGE OF ZAMBOANGA CITY, INC. - Times 14 Bold
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
class ResearchController extends Controller
{
    /**
     * Display a listing of the research papers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // For users/researchers, show all research papers
        if (Auth::user()->hasRole(['user', 'researcher'])) {
            $researchPapers = Research::all();
            return view('user.research.index', compact('researchPapers'));
        }
    
        // For head/admin, show all research papers
        if (Auth::user()->hasRole(['head', 'admin'])) {
            $researchPapers = Research::all();
            return view('head.research.index', compact('researchPapers'));
        }
    
        // Fallback if no roles match
        abort(403, 'Unauthorized access');
    }
    
    public function create()
    {
        // Ensure only users/researchers can create research
        if (!Auth::user()->hasRole(['user', 'researcher'])) {
            abort(403, 'Unauthorized to create research');
        }
    
        return view('user.research.create');
    }
    /**
     * Store a newly created research paper in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    // 1. Add 'email' to your validation rules.
    $request->validate([
        'title' => 'required|string|max:255',
        'course' => 'required|string|max:50',
        'researchers' => 'required|string',
        'adviser' => 'required|string|max:100',
        'year' => 'required|integer|min:2000|max:' . date('Y'),
        'email' => 'required|email|max:255', // <-- ADD THIS
        'abstract' => 'required|string',
        'keywords' => 'required|array',
        'keywords.*' => 'string|max:100',
        'research_design' => 'required|string|max:50',
        'research_type' => 'nullable|string|max:50',
        'respondents_count' => 'nullable|integer|min:0',
        'research_file' => 'nullable|string',
    ]);

    // File handling logic remains the same...
    $filePath = null;
    $tempFileName = $request->input('research_file');
    if ($tempFileName) {
        $tempPath = 'public/temp_research_files/' . $tempFileName;
        $finalPath = 'research_papers/' . $tempFileName;
        if (Storage::exists($tempPath)) {
            Storage::move($tempPath, 'public/' . $finalPath);
            $filePath = $finalPath;
        }
    }
    
    // Create new research paper record
    $research = new Research();
    $research->title = $request->title;
    $research->course = $request->course;
    $research->researchers = $request->researchers;
    $research->adviser = $request->adviser;
    $research->year = $request->year;
    $research->abstract = $request->abstract;
    $research->keywords = implode(', ', $request->keywords);
    $research->program = $request->program;
    $research->category = $request->category;
    $research->research_design = $request->research_design;
    $research->research_type = $request->research_type;
    $research->respondents_count = $request->respondents_count;
    $research->file_path = $filePath;
    
    // 2. Use the email from the form's input field.
    $research->email = $request->email;
    
    // 3. Set the approval status to 'approved' automatically.
    $research->approval_status = 'approved';

    $research->save();

    $prefix = Auth::user()->hasRole('head') ? 'head' : 'user';
    return redirect()->route("{$prefix}.research.index")->with('success', 'Research paper submitted and approved successfully.');
}

    /**
     * Display the specified research paper.
     *
     * @param  \App\Models\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function filepondUpload(Request $request)
{
    if (!$request->hasFile('research_file')) {
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    $file = $request->file('research_file');

    // Validate file
    $validator = Validator::make($request->all(), [
        'research_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 400);
    }

    // Generate a unique filename
    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    
    // Store file in a temporary directory
    $tempPath = $file->storeAs('temp_research_files', $fileName, 'public');

    // Return the server ID (filename) for FilePond
    return response()->json([
        'serverFileName' => $fileName
    ]);
}
    public function show(Research $research)
    {
        // Check if user has permission to view this research
        if (Auth::user()->role !== 'admin' && Auth::id() !== $research->user_id && $research->status !== 'published') {
            abort(403, 'Unauthorized action.');
        }

        return view('research.show', compact('research'));
    }
    public function filepondRevert(Request $request)
    {
        $fileName = $request->getContent();
        
        // Delete the temporary file
        $tempPath = 'public/temp_research_files/' . $fileName;
        
        if (Storage::exists($tempPath)) {
            Storage::delete($tempPath);
            return response('', 200);
        }
        
        return response('File not found', 404);
    }
    /**
     * Show the form for editing the specified research paper.
     *
     * @param  \App\Models\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function edit(Research $research)
    {
        // Check if user has permission to edit this research
        if (Auth::user()->role !== 'admin' && Auth::id() !== $research->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('research.edit', compact('research'));
    }

    /**
     * Update the specified research paper in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Research $research)
    {
        // Check if user has permission to update this research
        if (Auth::user()->role !== 'admin' && Auth::id() !== $research->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'course' => 'required|string|max:50',
            'researchers' => 'required|string',
            'adviser' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'abstract' => 'required|string',
            'keywords' => 'required|string|max:255',
            'research_design' => 'required|string|max:50',
            'research_type' => 'nullable|string|max:50',
            'respondents_count' => 'nullable|integer|min:0',
            'research_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
        ]);

        // Handle file upload if a new file is provided
        if ($request->hasFile('research_file')) {
            // Delete old file if exists
            if ($research->file_path && Storage::disk('public')->exists($research->file_path)) {
                Storage::disk('public')->delete($research->file_path);
            }
            
            // Store new file
            $file = $request->file('research_file');
            $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('research_papers', $fileName, 'public');
            $research->file_path = $filePath;
        }

        // Update research paper record
        $research->title = $request->title;
        $research->course = $request->course;
        $research->researchers = $request->researchers;
        $research->adviser = $request->adviser;
        $research->year = $request->year;
        $research->abstract = $request->abstract;
        $research->keywords = is_array($request->keywords) ? implode(', ', $request->keywords) : $request->keywords;
        $research->program = $request->program;
        $research->category = $request->category;
        $research->research_design = $request->research_design;
        $research->research_type = $request->research_type;
        $research->respondents_count = $request->respondents_count;
        
        // If not admin and the research is already approved, set status back to pending
        if (Auth::user()->role !== 'admin' && $research->status === 'published') {
            $research->status = 'pending';
        }
        
        $research->save();

        return redirect()->route('research.index')
            ->with('success', 'Research paper updated successfully.');
    }

    /**
     * Remove the specified research paper from storage.
     *
     * @param  \App\Models\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function destroy(Research $research)
    {
        // Check if user has permission to delete this research
        if (Auth::user()->role !== 'admin' && Auth::id() !== $research->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the file if exists
        if ($research->file_path && Storage::disk('public')->exists($research->file_path)) {
            Storage::disk('public')->delete($research->file_path);
        }

        // Delete the research record
        $research->delete();

        return redirect()->route('research.index')
            ->with('success', 'Research paper deleted successfully.');
    }

    /**
     * Display a listing of published research papers for browsing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function browse(Request $request)
    {
        $query = Research::where('status', 'published');

        // Apply filters if provided
        if ($request->has('course') && $request->course) {
            $query->where('course', $request->course);
        }

        if ($request->has('year') && $request->year) {
            $query->where('year', $request->year);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('abstract', 'like', '%' . $search . '%')
                  ->orWhere('keywords', 'like', '%' . $search . '%')
                  ->orWhere('researchers', 'like', '%' . $search . '%')
                  ->orWhere('adviser', 'like', '%' . $search . '%');
            });
        }

        $researchPapers = $query->orderBy('year', 'desc')
                               ->orderBy('created_at', 'desc')
                               ->paginate(12);

        // Get unique courses and years for filter dropdowns
        $courses = Research::where('status', 'published')->distinct()->pluck('course')->sort();
        $years = Research::where('status', 'published')->distinct()->pluck('year')->sort()->reverse();

        return view('research.browse', compact('researchPapers', 'courses', 'years'));
    }

    /**
     * Download the research paper file.
     *
     * @param  \App\Models\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function download(Research $research)
    {
        // Simple permission check - any authenticated user can download
        // Remove the complex role/user_id checks that might be causing issues
        
        if ($research->file_path && Storage::disk('public')->exists($research->file_path)) {
            return Storage::disk('public')->download($research->file_path, Str::slug($research->title) . '.pdf');
        }
        
        return back()->with('error', 'File not found.');
    }
    /**
     * Change the status of a research paper (admin only).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, Research $research)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,published,rejected',
            'review_comments' => 'nullable|string',
        ]);

        $research->status = $request->status;
        $research->review_comments = $request->review_comments;
        $research->save();

        return redirect()->back()->with('success', 'Research status updated successfully.');
    }
  /**
 * Generate a report for a research paper.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 *//**
 * Generate a report for a research paper.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function generateReport(Request $request)
{
     $id = $request->id;
    $researchExists = \App\Models\Research::find($id);
    dd("Checking for Research ID: " . $id, "Does it exist?", $researchExists);

    
    try {
        // Check if a specific ID was provided
        if ($request->has('id')) {
            // Find the research paper
            $research = Research::findOrFail($request->id);
            
            // Create new PDF document using custom class
            $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // Set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor(Auth::user()->name);
            $pdf->SetTitle($research->title);
            $pdf->SetSubject('Research Paper Report');
            $pdf->SetKeywords('Research, Report, ' . $research->keywords);
            
            // Set header and footer fonts
            $pdf->setHeaderFont(Array('times', 'B', 14));
            $pdf->setFooterFont(Array('helvetica', '', 8));
            
            // Set default monospaced font
            $pdf->SetDefaultMonospacedFont('courier');
            
            // Set margins - adjust top margin to accommodate the custom header
            $pdf->SetMargins(15, 40, 15);
            $pdf->SetHeaderMargin(10);
            $pdf->SetFooterMargin(10);
            
            // Set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 15);
            
            // Add a page
            $pdf->AddPage();
            
            // Add "Research Title:" label - centered
            $pdf->SetFont('times', 'B', 14);
            
            // HTML method for research title with label
            $titleHtml = '
            <style>
                h1 {
                    font-family: times;
                    font-size: 14pt;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 15px;
                }
                .title-label {
                    font-weight: bold;
                }
            </style>
            
            <h1><span class="title-label">Research Title:</span> ' . htmlspecialchars($research->title) . '</h1>';
            
            $pdf->writeHTML($titleHtml, true, false, true, false, '');
            $pdf->Ln(2);
            
            // Set font for content
            $pdf->SetFont('times', '', 12);
            
            // Generate research information in paragraph format
            $html = '
            <style>
                body {
                    font-family: times;
                    font-size: 12pt;
                    line-height: 1.5;
                }
                p {
                    margin-bottom: 10px;
                    text-align: justify;
                }
                .label {
                    font-weight: bold;
                }
                h2 {
                    font-family: times;
                    font-size: 14pt;
                    font-weight: bold;
                    color: #4b0082; /* Indigo color for headings */
                    margin-top: 15px;
                    margin-bottom: 10px;
                    border-bottom: 1px solid #4b0082;
                    padding-bottom: 3px;
                }
                .abstract {
                    text-align: justify;
                    line-height: 1.5;
                    margin-bottom: 15px;
                }
                .keywords {
                    font-style: italic;
                    margin-bottom: 15px;
                }
            </style>
            
            <p><span class="label">Course:</span> ' . htmlspecialchars($research->course) . '</p>
            <p><span class="label">Year:</span> ' . htmlspecialchars($research->year) . '</p>
            <p><span class="label">Researchers:</span> ' . htmlspecialchars($research->researchers) . '</p>
            <p><span class="label">Adviser:</span> ' . htmlspecialchars($research->adviser) . '</p>
            <p><span class="label">Research Design:</span> ' . htmlspecialchars($research->research_design) . 
            ($research->research_type ? ' - ' . htmlspecialchars($research->research_type) : '') . '</p>';
            
            // Add number of respondents if available
            if (!empty($research->respondents_count)) {
                $html .= '<p><span class="label">Number of Respondents:</span> ' . htmlspecialchars($research->respondents_count) . '</p>';
            }
            
            $html .= '
            <h2>ABSTRACT</h2>
            <div class="abstract">' . htmlspecialchars($research->abstract) . '</div>
            
            <h2>KEYWORDS</h2>
            <div class="keywords">' . htmlspecialchars($research->keywords) . '</div>';
            
            // Print content
            $pdf->writeHTML($html, true, false, true, false, '');
            
            // Close and output PDF document
            return $pdf->Output('research_report_' . $research->id . '.pdf', 'D');
        } else {
            // Generate a comprehensive report of multiple research papers
            $researchPapers = Research::all();
            
            // Create new PDF document using custom class
            $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // Set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor(Auth::user()->name);
            $pdf->SetTitle('Research Papers Report');
            $pdf->SetSubject('Comprehensive Research Report');
            
            // Set header and footer fonts
            $pdf->setHeaderFont(Array('times', 'B', 14));
            $pdf->setFooterFont(Array('helvetica', '', 8));
            
            // Set default monospaced font
            $pdf->SetDefaultMonospacedFont('courier');
            
            // Set margins - adjust top margin to accommodate the custom header
            $pdf->SetMargins(15, 40, 15);
            $pdf->SetHeaderMargin(10);
            $pdf->SetFooterMargin(10);
            
            // Set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 15);
            
            // Add a page
            $pdf->AddPage();
            
            // Set font for title
            $pdf->SetFont('times', 'B', 16);
            
            // Add title
            $pdf->Cell(0, 10, 'COMPREHENSIVE RESEARCH PAPERS REPORT', 0, 1, 'C');
            $pdf->Ln(5);
            
            // Set font for content
            $pdf->SetFont('times', '', 12);
            
            // Format multiple papers as a list
            $html = '
            <style>
                body {
                    font-family: times;
                    font-size: 12pt;
                    line-height: 1.5;
                }
                h3 {
                    font-size: 13pt;
                    color: #4b0082;
                    margin-top: 20px;
                    margin-bottom: 5px;
                    border-left: 3px solid #4b0082;
                    padding-left: 10px;
                }
                p {
                    margin: 5px 0 15px 0;
                    text-align: justify;
                }
                .label {
                    font-weight: bold;
                    color: #333;
                    display: inline-block;
                    width: 120px;
                }
                .paper-container {
                    margin-bottom: 20px;
                    padding-bottom: 15px;
                    border-bottom: 1px dashed #cccccc;
                }
            </style>';
            
            $count = 1;
            foreach ($researchPapers as $paper) {
                $html .= '
                <div class="paper-container">
                    <h3>' . $count . '. Research Title: ' . htmlspecialchars($paper->title) . '</h3>
                    <p><span class="label">Course:</span> ' . htmlspecialchars($paper->course) . '</p>
                    <p><span class="label">Researchers:</span> ' . htmlspecialchars($paper->researchers) . '</p>
                    <p><span class="label">Adviser:</span> ' . htmlspecialchars($paper->adviser) . '</p>
                    <p><span class="label">Year:</span> ' . htmlspecialchars($paper->year) . '</p>
                    <p><span class="label">Design:</span> ' . htmlspecialchars($paper->research_design) . 
                    ($paper->research_type ? ' - ' . htmlspecialchars($paper->research_type) : '') . '</p>';
                
                // Add number of respondents if available
                if (!empty($paper->respondents_count)) {
                    $html .= '<p><span class="label">Respondents:</span> ' . htmlspecialchars($paper->respondents_count) . '</p>';
                }
                
                $html .= '</div>';
                $count++;
            }
            
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');
            
            // Close and output PDF document
            return $pdf->Output('research_report_all_' . date('YmdHis') . '.pdf', 'D');
        }
    } catch (\Exception $e) {
        // Log the error and return with error message
        Log::error('PDF Generation Error: ' . $e->getMessage());
        return back()->with('error', 'Failed to generate report: ' . $e->getMessage());
    }
}

public function showApprovals()
{
    // Check if user has appropriate role
    if (!Auth::user()->hasRole(['head', 'admin', 'user'])) {
        abort(403, 'Unauthorized action.');
    }

    // Fetch research papers for each status category
    $pendingResearch = Research::where('approval_status', 'pending')->latest()->get();
    $approvedResearch = Research::where('approval_status', 'approved')->latest()->get();
    $rejectedResearch = Research::where('approval_status', 'rejected')->latest()->get();

    // Determine view based on user role
    if (Auth::user()->hasRole(['head', 'admin'])) {
        return view('head.research.approvals', compact('pendingResearch', 'approvedResearch', 'rejectedResearch'));
    } else {
        // For regular users
        return view('user.research.approvals', compact('pendingResearch', 'approvedResearch', 'rejectedResearch'));
    }
}

public function approve(Research $research)
{
    // Use the save() method for maximum reliability.
    $research->approval_status = 'approved';
    $research->save();

    // The 'email' field is saved by your GuestResearchController,
    // so this check will now work correctly.
    if ($research->email) {
        try {
            Mail::to($research->email)->send(new ResearchStatusUpdated($research));
        } catch (\Exception $e) {
            // Log the error if the email fails, but don't stop the process.
            Log::error('Email sending failed for research ID ' . $research->id . ': ' . $e->getMessage());
            
            // Redirect based on user role
            if (Auth::user()->hasRole(['head', 'admin'])) {
                return redirect()->route('head.research.approvals')->with('success', 'Research approved, but failed to send notification email.');
            } else {
                return redirect()->route('user.research.index')->with('success', 'Research approved, but failed to send notification email.');
            }
        }
    }

    // Redirect based on user role
    if (Auth::user()->hasRole(['head', 'admin'])) {
        return redirect()->route('head.research.approvals')->with('success', 'Research paper has been approved.');
    } else {
        return redirect()->route('user.research.index')->with('success', 'Research paper has been approved.');
    }
}


public function reject(Research $research)
{
    // Use the save() method for maximum reliability.
    $research->approval_status = 'rejected';
    $research->save();

    // The 'email' field is saved by your GuestResearchController,
    // so this check will now work correctly.
    if ($research->email) {
        try {
            Mail::to($research->email)->send(new ResearchStatusUpdated($research));
        } catch (\Exception $e) {
            // Log the error if the email fails, but don't stop the process.
            Log::error('Email sending failed for research ID ' . $research->id . ': ' . $e->getMessage());
            return redirect()->route('head.research.approvals')->with('success', 'Research rejected, but failed to send notification email.');
        }
    }

    return redirect()->route('head.research.approvals')->with('success', 'Research paper has been rejected.');
}
}