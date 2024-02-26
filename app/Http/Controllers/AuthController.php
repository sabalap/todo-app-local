<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        User::create($formFields);

        return redirect()->route('login')->with('success', 'Congratulations, you have successfully registered!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('todos')->with('success','Signed in successfully!');
        }

        return back()->with('invalid', 'Credentials are not correct!');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'You have logged out successfully!');
    }
}
