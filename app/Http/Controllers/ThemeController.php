<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->session()->put('dark_mode', !$request->session()->get('dark_mode', false));
        return back();
    }
}