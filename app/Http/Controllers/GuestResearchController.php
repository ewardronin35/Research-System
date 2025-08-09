<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResearchCode;
use App\Models\Research; // Make sure your model is named Research
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Required for file handling

class GuestResearchController extends Controller
{
    /**
     * Show the form for the user to enter their verification code.
     */
    public function showEnterCodeForm()
    {
        return view('guest.enter-code');
    }

    /**
     * Verify the code entered by the user.
     */
    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required|string|exists:research_codes,code']);
        $code = ResearchCode::where('code', $request->code)->first();

        if ($code->is_used) {
            return back()->withErrors(['code' => 'This code has already been used.']);
        }

        if ($code->expires_at && $code->expires_at < now()) {
            return back()->withErrors(['code' => 'This code has expired.']);
        }

        session(['validated_research_code' => $code->code]);
        return redirect()->route('guest.research.form');
    }

    /**
     * Show the research submission form to the guest.
     */
    public function showResearchForm()
    {
        if (!session()->has('validated_research_code')) {
            return redirect()->route('guest.research.enter_code');
        }
        return view('guest.research-form');
    }
public function filepondUpload(Request $request)
    {
        if ($request->hasFile('research_file')) {
            $file = $request->file('research_file');
            // Store the file in a temporary directory and return the unique path
            $path = $file->store('tmp', 'public');
            return response($path, 200)->header('Content-Type', 'text/plain');
        }
        return response('No file uploaded.', 400);
    }

    /**
     * Handles the revert action for FilePond.
     */
    public function filepondRevert(Request $request)
    {
        $filePath = 'tmp/' . basename($request->getContent());
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        return response('', 200);
    }
    /**
     * Store the research submitted by the guest.
     */
public function storeResearch(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'course' => 'required|string',
        'year' => 'required|integer|min:2000',
        'researchers' => 'required|string',
        'adviser' => 'required|string',
        'email' => 'required|email|max:255', // <-- VALIDATE EMAIL
        'abstract' => 'required|string',
        'keywords' => 'required|array|min:1',
        'keywords.*' => 'string',
        'research_design' => 'required|string',
        'respondents_count' => 'nullable|integer|min:0',
        'research_file_path' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->route('guest.research.form')
                    ->withErrors($validator)
                    ->withInput();
    }

     $tempPath = $request->input('research_file_path');
        $finalPath = str_replace('tmp/', 'research_papers/', $tempPath);
        Storage::disk('public')->move($tempPath, $finalPath);
    $keywords_string = implode(',', $request->input('keywords'));

    Research::create([
        'title' => $request->title,
        'course' => $request->course,
        'year' => $request->year,
        'researchers' => $request->researchers,
        'adviser' => $request->adviser,
        'email' => $request->email, // <-- SAVE EMAIL
        'abstract' => $request->abstract,
        'keywords' => $keywords_string,
        'research_design' => $request->research_design,
        'respondents_count' => $request->respondents_count,
        'file_path' => $finalPath, // Save the final path
    ]);

    $code = ResearchCode::where('code', session('validated_research_code'))->first();
    if ($code) {
        $code->update(['is_used' => true]);
    }

    $request->session()->forget('validated_research_code');

    // Redirect with a more informative success message
    return redirect()->route('guest.research.enter_code')
        ->with('success', 'Thank you! Your research has been submitted and is now pending approval. You will receive an email update shortly.');
}
}