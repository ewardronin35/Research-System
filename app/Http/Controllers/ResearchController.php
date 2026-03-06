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
use App\Mail\ResearchStatusUpdated; 
use Illuminate\Support\Facades\Mail; 

use TCPDF;

class MYPDF extends TCPDF {
    public function Header() {
        // Add watermark first (so it appears behind text)
        $watermarkPath = public_path('pilarLogo.png');
        if (file_exists($watermarkPath)) {
            $pageWidth = $this->getPageWidth();
            $pageHeight = $this->getPageHeight();
            $watermarkWidth = 150; 
            $watermarkHeight = 150;
            $watermarkX = ($pageWidth - $watermarkWidth) / 2;
            $watermarkY = ($pageHeight - $watermarkHeight) / 2;
            
            $this->SetAlpha(0.1); 
            $this->Image($watermarkPath, $watermarkX, $watermarkY, $watermarkWidth, $watermarkHeight, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
            $this->SetAlpha(1); 
        }
        
        // Logos and Header Text
        $leftLogoPath = public_path('pilarLogo.png');
        if (file_exists($leftLogoPath)) {
            $this->Image($leftLogoPath, 15, 10, 20, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        $rightLogoPath = public_path('Research.png');
        if (file_exists($rightLogoPath)) {
            $this->Image($rightLogoPath, 175, 10, 20, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        $this->SetY(10);
        $this->SetX(15);
        $this->SetFont('times', 'B', 14);
        $this->Cell(180, 6, 'PILAR COLLEGE OF ZAMBOANGA CITY, INC.', 0, 1, 'C');
        
        $this->SetX(15);
        $this->SetFont('helvetica', '', 12);
        $this->Cell(180, 6, 'R. T. Lim Boulevard, Zamboanga City', 0, 1, 'C');
        $this->SetX(15);
        $this->Cell(180, 6, 'Tel. No. (062) 991 5410', 0, 1, 'C');
        
        $this->Ln(5);
        $this->SetDrawColor(128, 0, 128); 
        $this->SetLineWidth(0.7); 
        $currentY = $this->GetY();
        $this->Line(15, $currentY, 195, $currentY);
        
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.2); 
        $this->Ln(5);
    }
    
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

class ResearchController extends Controller
{
    public function index()
    {
        // FIX: Check for 'Super Admin'
        $prefix = Auth::user()->hasRole('Super Admin') ? 'head' : 'user';
        
        if (Auth::user()->hasRole('Super Admin')) {
            $research = Research::latest()->paginate(10);
        } else {
            // 'Research Staff' view
            $research = Research::where('user_id', Auth::id())->latest()->paginate(10);
        }

        return view($prefix . '.research.index', compact('research'));
    }

    public function create()
    {
        // FIX: Update role check to 'Research Staff' (and allow Admin if needed)
        if (!Auth::user()->hasRole(['Research Staff', 'Super Admin'])) {
            abort(403, 'Unauthorized to create research');
        }
    
        return view('user.research.create');
    }

    public function store(Request $request)
    {
        Log::info('--- Starting Research Store ---');
        Log::info('Request data:', $request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'course' => 'required|string|max:50',
            'researchers' => 'required|string',
            'adviser' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'email' => 'required|email|max:255',
            'abstract' => 'required|string',
            'keywords' => 'required|array',
            'keywords.*' => 'string|max:100',
            'research_design' => 'required|string|max:50',
            'research_type' => 'nullable|string|max:50',
            'respondents_count' => 'nullable|integer|min:0',
            'research_file' => 'nullable|string',
        ]);

        $filePath = null;
        $tempFileName = $request->input('research_file');

        if ($tempFileName) {
            Log::info('Temp file name received from form: ' . $tempFileName);
            $tempPath = 'temp_research_files/' . $tempFileName;
            $finalPath = 'research_papers/' . $tempFileName;
            Log::info('Checking for temp file on public disk at path: ' . $tempPath);

            if (Storage::disk('public')->exists($tempPath)) {
                Log::info('Temp file found. Moving to: ' . $finalPath);
                Storage::disk('public')->move($tempPath, $finalPath);
                $filePath = $finalPath;
                Log::info('File path set to: ' . $filePath);
            } else {
                Log::error('Temp file NOT FOUND at path: ' . $tempPath);
            }
        } else {
            Log::warning('No research_file input was received from the form.');
        }
        
        $research = new Research();
        $research->user_id = Auth::id(); // Ensure we save who created it
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
        $research->email = $request->email;
        $research->approval_status = 'approved';
        $research->file_path = $filePath;

        $research->save();
        Log::info('--- Research Store Complete ---');

        // FIX: Redirect based on new roles
        $prefix = Auth::user()->hasRole('Super Admin') ? 'head' : 'user';
        return redirect()->route("{$prefix}.research.index")->with('success', 'Research paper submitted and approved successfully.');
    }

    public function filepondUpload(Request $request)
    {
        if (!$request->hasFile('research_file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('research_file');

        $validator = Validator::make($request->all(), [
            'research_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $tempPath = $file->storeAs('temp_research_files', $fileName, 'public');

        return $fileName;
    }

    public function show(Research $research)
    {
        // FIX: Use hasRole and check ownership properly
        $hasAccess = Auth::user()->hasRole('Super Admin') || 
                     Auth::id() === $research->user_id || 
                     $research->status === 'published';

        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }

        return view('research.show', compact('research'));
    }

    public function filepondRevert(Request $request)
    {
        $fileName = $request->getContent();
        $tempPath = 'public/temp_research_files/' . $fileName;
        
        if (Storage::exists($tempPath)) {
            Storage::delete($tempPath);
            return response('', 200);
        }
        
        return response('File not found', 404);
    }

    public function loadFile(Research $research)
    {
        // FIX: Allow 'Super Admin' and 'Research Staff'
        if (!Auth::user()->hasRole(['Super Admin', 'Research Staff'])) {
            abort(403);
        }

        if (!$research->file_path || !Storage::disk('public')->exists($research->file_path)) {
            abort(404);
        }

        $filePath = Storage::disk('public')->path($research->file_path);
        return response()->file($filePath);
    }

    public function removeFile(Request $request)
    {
        // FIX: Allow 'Super Admin' and 'Research Staff'
        if (!Auth::user()->hasRole(['Super Admin', 'Research Staff'])) {
            abort(403);
        }
        
        $researchId = $request->getContent();

        if ($researchId) {
            $research = Research::find($researchId);
            // Ensure user owns research or is admin
            if (Auth::user()->hasRole('Research Staff') && $research->user_id !== Auth::id()) {
                 abort(403);
            }

            if ($research && $research->file_path) {
                Storage::disk('public')->delete($research->file_path);
                $research->file_path = null;
                $research->save();
                return response()->json(['success' => 'File removed successfully.']);
            }
        }

        return response()->json(['error' => 'Could not remove file.'], 500);
    }

    public function edit(Research $research)
    {
        // FIX: Use hasRole checks
        $isOwner = Auth::id() === $research->user_id;
        $isAdmin = Auth::user()->hasRole('Super Admin');

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Unauthorized action.');
        }

        return view('research.edit', compact('research'));
    }

    public function getResearchData(Research $research)
    {
        // FIX: Allow 'Super Admin' and 'Research Staff'
        if (!Auth::user()->hasRole(['Super Admin', 'Research Staff'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($research);
    }

    public function update(Request $request, Research $research)
    {
        // FIX: Allow 'Super Admin' and 'Research Staff'
        if (!Auth::user()->hasRole(['Super Admin', 'Research Staff'])) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ensure ownership
        if (Auth::user()->hasRole('Research Staff') && $research->user_id !== Auth::id()) {
             abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'course' => 'required|string|max:50',
            'researchers' => 'required|string',
            'adviser' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'abstract' => 'required|string',
            'keywords' => 'required|array',
            'keywords.*' => 'string|max:255',
            'research_design' => 'required|string|max:50',
            'research_type' => 'nullable|string|max:50',
            'respondents_count' => 'nullable|integer|min:0',
            'research_file' => 'nullable|string',
        ]);

        $tempFileName = $request->input('research_file');
        
        if ($tempFileName) {
            $tempPath = 'temp_research_files/' . $tempFileName;
            $finalPath = 'research_papers/' . $tempFileName;

            if (Storage::disk('public')->exists($tempPath)) {
                if ($research->file_path && Storage::disk('public')->exists($research->file_path)) {
                    Storage::disk('public')->delete($research->file_path);
                }
                
                Storage::disk('public')->move($tempPath, $finalPath);
                $research->file_path = $finalPath;
            }
        }

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
        
        $research->save();

        // FIX: Redirect based on 'Super Admin'
        if (Auth::user()->hasRole('Super Admin')) {
            return redirect()->route('head.research.index')
                ->with('success', 'Research paper updated successfully.');
        } else {
            return redirect()->route('user.research.index')
                ->with('success', 'Research paper updated successfully.');
        }
    }

    public function destroy(Research $research)
    {
        // FIX: Allow 'Super Admin' and 'Research Staff'
        if (!Auth::user()->hasRole(['Super Admin', 'Research Staff'])) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ensure ownership if not admin
        if (Auth::user()->hasRole('Research Staff') && $research->user_id !== Auth::id()) {
             abort(403, 'Unauthorized action.');
        }

        if ($research->file_path && Storage::disk('public')->exists($research->file_path)) {
            Storage::disk('public')->delete($research->file_path);
        }

        $research->delete();

        // FIX: Redirect based on 'Super Admin'
        if (Auth::user()->hasRole('Super Admin')) {
            return redirect()->route('head.research.index')
                ->with('success', 'Research paper deleted successfully.');
        } else {
            return redirect()->route('user.research.index')
                ->with('success', 'Research paper deleted successfully.');
        }
    }

    public function browse(Request $request)
    {
        $query = Research::where('status', 'published');

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

        $courses = Research::where('status', 'published')->distinct()->pluck('course')->sort();
        $years = Research::where('status', 'published')->distinct()->pluck('year')->sort()->reverse();

        return view('research.browse', compact('researchPapers', 'courses', 'years'));
    }

    public function download(Research $research)
    {
        // FIX: Allow Super Admin and Research Staff
        if (!Auth::user()->hasRole(['Super Admin', 'Research Staff'])) {
            abort(403, 'Unauthorized action.');
        }

        if (Storage::disk('public')->exists($research->file_path)) {
            return Storage::disk('public')->download($research->file_path);
        }

        return back()->with('error', 'File not found.');
    }

    public function changeStatus(Request $request, Research $research)
    {
        // FIX: Check for 'Super Admin'
       if (!Auth::user()->hasRole('Super Admin')) {
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

    public function generateReport(Request $request)
    {
        try {
            if ($request->has('id')) {
                $research = Research::findOrFail($request->id);
                
                $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor(Auth::user()->name);
                $pdf->SetTitle($research->title);
                $pdf->SetSubject('Research Paper Report');
                $pdf->SetKeywords('Research, Report, ' . $research->keywords);
                $pdf->setHeaderFont(Array('times', 'B', 14));
                $pdf->setFooterFont(Array('helvetica', '', 8));
                $pdf->SetDefaultMonospacedFont('courier');
                $pdf->SetMargins(15, 40, 15);
                $pdf->SetHeaderMargin(10);
                $pdf->SetFooterMargin(10);
                $pdf->SetAutoPageBreak(TRUE, 15);
                $pdf->AddPage();
                $pdf->SetFont('times', 'B', 14);
                
                $titleHtml = '
                <style>
                    h1 { font-family: times; font-size: 14pt; font-weight: bold; text-align: center; margin-bottom: 15px; }
                    .title-label { font-weight: bold; }
                </style>
                <h1><span class="title-label">Research Title:</span> ' . htmlspecialchars($research->title) . '</h1>';
                
                $pdf->writeHTML($titleHtml, true, false, true, false, '');
                $pdf->Ln(2);
                $pdf->SetFont('times', '', 12);
                
                $html = '
                <style>
                    body { font-family: times; font-size: 12pt; line-height: 1.5; }
                    p { margin-bottom: 10px; text-align: justify; }
                    .label { font-weight: bold; }
                    h2 { font-family: times; font-size: 14pt; font-weight: bold; color: #4b0082; margin-top: 15px; margin-bottom: 10px; border-bottom: 1px solid #4b0082; padding-bottom: 3px; }
                    .abstract { text-align: justify; line-height: 1.5; margin-bottom: 15px; }
                    .keywords { font-style: italic; margin-bottom: 15px; }
                </style>
                <p><span class="label">Course:</span> ' . htmlspecialchars($research->course) . '</p>
                <p><span class="label">Year:</span> ' . htmlspecialchars($research->year) . '</p>
                <p><span class="label">Researchers:</span> ' . htmlspecialchars($research->researchers) . '</p>
                <p><span class="label">Adviser:</span> ' . htmlspecialchars($research->adviser) . '</p>
                <p><span class="label">Research Design:</span> ' . htmlspecialchars($research->research_design) . 
                ($research->research_type ? ' - ' . htmlspecialchars($research->research_type) : '') . '</p>';
                
                if (!empty($research->respondents_count)) {
                    $html .= '<p><span class="label">Number of Respondents:</span> ' . htmlspecialchars($research->respondents_count) . '</p>';
                }
                
                $html .= '
                <h2>ABSTRACT</h2>
                <div class="abstract">' . htmlspecialchars($research->abstract) . '</div>
                <h2>KEYWORDS</h2>
                <div class="keywords">' . htmlspecialchars($research->keywords) . '</div>';
                
                $pdf->writeHTML($html, true, false, true, false, '');
                return $pdf->Output('research_report_' . $research->id . '.pdf', 'D');

            } else {
                $researchPapers = Research::all();
                $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor(Auth::user()->name);
                $pdf->SetTitle('Research Papers Report');
                $pdf->SetSubject('Comprehensive Research Report');
                $pdf->setHeaderFont(Array('times', 'B', 14));
                $pdf->setFooterFont(Array('helvetica', '', 8));
                $pdf->SetDefaultMonospacedFont('courier');
                $pdf->SetMargins(15, 40, 15);
                $pdf->SetHeaderMargin(10);
                $pdf->SetFooterMargin(10);
                $pdf->SetAutoPageBreak(TRUE, 15);
                $pdf->AddPage();
                $pdf->SetFont('times', 'B', 16);
                
                $pdf->Cell(0, 10, 'COMPREHENSIVE RESEARCH PAPERS REPORT', 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->SetFont('times', '', 12);
                
                $html = '
                <style>
                    body { font-family: times; font-size: 12pt; line-height: 1.5; }
                    h3 { font-size: 13pt; color: #4b0082; margin-top: 20px; margin-bottom: 5px; border-left: 3px solid #4b0082; padding-left: 10px; }
                    p { margin: 5px 0 15px 0; text-align: justify; }
                    .label { font-weight: bold; color: #333; display: inline-block; width: 120px; }
                    .paper-container { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px dashed #cccccc; }
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
                    
                    if (!empty($paper->respondents_count)) {
                        $html .= '<p><span class="label">Respondents:</span> ' . htmlspecialchars($paper->respondents_count) . '</p>';
                    }
                    
                    $html .= '</div>';
                    $count++;
                }
                
                $pdf->writeHTML($html, true, false, true, false, '');
                return $pdf->Output('research_report_all_' . date('YmdHis') . '.pdf', 'D');
            }
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    public function showApprovals()
    {
        // FIX: Allow both 'Super Admin' AND 'Research Staff'
        if (!Auth::user()->hasRole(['Super Admin', 'Research Staff'])) {
             abort(403, 'Unauthorized action.');
        }

        $pendingResearch = Research::where('approval_status', 'pending')->latest()->get();
        
        // FIX: Determine prefix based on 'Super Admin'
        $prefix = Auth::user()->hasRole('Super Admin') ? 'head' : 'user';
        return view($prefix . '.research.approvals', compact('pendingResearch'));
    }

    public function approve(Research $research)
    {
        // FIX: Check for 'Super Admin'
        if (!Auth::user()->hasRole('Super Admin')) {
             abort(403, 'Unauthorized action.');
        }

        $research->approval_status = 'approved';
        $research->save();

        if ($research->email) {
            try {
                Mail::to($research->email)->send(new ResearchStatusUpdated($research));
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('head.research.approvals')->with('success', 'Research paper has been approved.');
    }

    public function reject(Research $research)
    {
        // FIX: Allow 'Super Admin' only (Staff usually can't reject unless specified)
        // If staff can reject, add 'Research Staff' to array
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $research->approval_status = 'rejected';
        $research->save();

        if ($research->email) {
            try {
                Mail::to($research->email)->send(new ResearchStatusUpdated($research));
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage());
            }
        }

        // FIX: Redirect based on role
        if (Auth::user()->hasRole('Super Admin')) {
            return redirect()->route('head.research.approvals')->with('success', 'Research paper has been rejected.');
        } else {
            return redirect()->route('user.research.approvals')->with('success', 'Research paper has been rejected.');
        }
    }
}