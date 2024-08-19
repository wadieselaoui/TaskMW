<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                Log::info("User {$user->id} is logging out.");
            } else {
                Log::warning("An unauthenticated user attempted to log out.");
            }

            Auth::logout();
            Log::info("User {$user->id} successfully logged out.");

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        } catch (\Exception $e) {
            Log::error("An error occurred during logout: " . $e->getMessage());
            return redirect('/')->withErrors('An error occurred while logging out. Please try again.');
        }
    }
}
