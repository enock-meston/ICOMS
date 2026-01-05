<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $title = "Kwinjira";
        return view('login', compact('title'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function loginMethod(Request $request)
    {
        // First, ensure no one is logged in
        Auth::guard('web')->logout();
        Auth::guard('cooperative')->logout();

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:1'],
        ]);

        $isCoperativeUser = $request->has('isCoperativeUser');
        $guard = $isCoperativeUser ? 'cooperative' : 'web';
        $email = trim($request->input('email'));
        $password = $request->input('password');

        // Ensure email and password are not empty
        if (empty($email) || empty($password)) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        }

        // Determine which table to query
        $tableName = $isCoperativeUser ? 'co_users' : 'users';

        // Query database directly to get user and password (bypassing model casts)
        // Use strict comparison and check count
        $userRecord = DB::table($tableName)
            ->where('email', '=', $email)
            ->first();

        // CRITICAL CHECK: If user doesn't exist, immediately fail
        if ($userRecord === null || !isset($userRecord->id) || empty($userRecord->id)) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        }

        // Get the raw password from database (no casts applied)
        $hashedPassword = $userRecord->password ?? null;

        // If password is null or empty, user record is invalid
        if (empty($hashedPassword) || !is_string($hashedPassword) || strlen($hashedPassword) < 10) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        }

        // Verify password using Hash::check - this is the critical check
        // Hash::check returns false if password doesn't match
        if (!Hash::check($password, $hashedPassword)) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        }

        // Now get the model instance for login
        if ($isCoperativeUser) {
            $user = \App\Models\CoOperative\CoUser::find($userRecord->id);
        } else {
            $user = \App\Models\User::find($userRecord->id);
        }

        // Final check: user model must exist and have valid ID
        if ($user === null || !isset($user->id) || $user->id != $userRecord->id) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        }

        // Only log in if ALL checks pass
        Auth::guard($guard)->login($user);
        $request->session()->regenerate();

        $userType = $isCoperativeUser ? 'Co-operative User' : 'Admin User';
        return redirect()->intended(route('dashboard'))
            ->with('success', "Login successful as {$userType}");
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        // Logout from both guards to ensure complete logout
        Auth::guard('web')->logout();
        Auth::guard('cooperative')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
