<?php

namespace App\Http\Controllers;

use App\Models\Role;
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

        $users = User::with('role')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('contact', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('role', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('users.index', ['users' => $users]);
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $fields = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->update($fields);

        return redirect()->route('users')->with('success', 'User updated successfully.');
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
