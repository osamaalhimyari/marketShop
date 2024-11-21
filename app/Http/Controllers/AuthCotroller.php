<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthCotroller extends Controller
{

    // Show the login form view
    public function goLoginPage()
    {
        return view('auth.Login'); // Adjust path if needed
    }


    public function login(Request $request)
    {

        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication was successful; redirect to intended page
            return redirect()->intended('admin/'); // Adjust 'dashboard' to the correct route
        }

        // Authentication failed; redirect back with an error
        return redirect()->back()
            ->withErrors(['email' => 'Invalid email or password'])
            ->withInput();
    }

    //    Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
