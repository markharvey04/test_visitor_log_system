<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Show Login Page
    public function showLogin()
    {
        // If already logged in, go to dashboard
        if (session()->has('LoggedUser')) {
            return redirect()->route('visitors.index');
        }
        return view('auth.login');
    }

    // 2. Handle Login Logic
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'Username' => 'required',
            'password' => 'required'
        ]);

        // A. Find the user in the database
        $user = DB::table('staff')
            ->where('Username', $request->Username)
            ->first();

        // B. Check if user exists AND password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            
            // --- CRITICAL STEP: SAVE SESSION DATA ---
            // This is what the Middleware looks for ("LoggedUser")
            $request->session()->put('LoggedUser', $user->StaffID);
            $request->session()->put('RoleID', $user->RoleID);
            $request->session()->put('Name', $user->Name);
            
            // Redirect to Dashboard
            return redirect()->route('visitors.index');
        }

        // C. Login Failed? Go back with error message
        return back()->with('error', 'Incorrect username or password.');
    }

    // 3. Logout
    public function logout()
    {
        if (session()->has('LoggedUser')) {
            session()->pull('LoggedUser');
            session()->pull('RoleID');
            session()->pull('Name');
        }
        return redirect()->route('login');
    }
}