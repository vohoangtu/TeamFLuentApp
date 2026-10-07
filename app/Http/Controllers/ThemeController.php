<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ThemeController extends Controller
{
    /**
     * Display the Theme & Blade Component Showcase.
     */
    public function index(): View
    {
        return view('themes.index');
    }
}
