<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResearchCode;
use Illuminate\Support\Str;

class ResearchCodeController extends Controller
{
    /**
     * Display the code management page.
     */
  public function index()
{
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    // OLD CODE:
    // if ($user->hasRole('head')) {
    //     return view('head.codes.index');
    // } elseif ($user->hasRole('user') || $user->hasRole('researcher')) {
    //     return view('user.codes.index');
    // }

    // NEW CODE:
    if ($user->hasRole('Super Admin')) {
        return view('head.codes.index');
    } elseif ($user->hasRole('Research Staff')) {
        return view('user.codes.index');
    }

    return redirect()->route('dashboard')->with('error', 'Unauthorized access');
}
    /**
     * Fetch all codes for the Handsontable component.
     */
// In app/Http/Controllers/Head/ResearchCodeController.php

public function fetchAllCodes()
{
    $codes = ResearchCode::latest()->get(['code', 'is_used', 'created_at']);

    // Format the date for each code
    $codes->transform(function ($code) {
        $code->created_at_formatted = $code->created_at->format('M d, Y h:i A');
        return $code;
    });

    // Wrap the collection in a "data" key as expected by DataTables
    return response()->json(['data' => $codes]);
}
    /**
     * Generate a specified number of unique guest codes.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'code_count' => 'required|integer|min:1|max:100',
        ]);

        for ($i = 0; $i < $request->input('code_count'); $i++) {
            ResearchCode::create([
                'code' => Str::random(8),
                'is_used' => false,
            ]);
        }

        return redirect()->back()->with('success', $request->input('code_count') . ' new code(s) generated successfully!');
    }
}