<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\EmailDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('contact', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhereHas('role', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('users.index', ['users' => $users]);
    }
    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'max:255', 'email', 'unique:users', new EmailDomain],
            'contact' => ['required', 'max:50'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create($fields);

        $fields['role_id'] = DB::table('roles')->where('name', 'ROLE_USER')->value('id');

        Auth::login($user);

        return redirect()->intended('/');
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email', new EmailDomain],
            'password' => ['required'],
        ]);

        if (Auth::attempt($fields)) {
            return redirect()->intended('/');
        } else {
            return back()->withErrors([
                'failed' => 'The provided credentials do not match our records.'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
