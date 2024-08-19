<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            Log::info("Home page accessed.");

            return view('home');
        } catch (\Exception $e) {
            Log::error("An error occurred while accessing the home page: " . $e->getMessage());
            return redirect('/')->withErrors('An error occurred while loading the home page. Please try again.');
        }
    }
}
