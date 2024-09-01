<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Rules\EmailDomain;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit($id)
    {
        $user = User::with('role')->findOrFail($id);

        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $fields = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id, new EmailDomain],
            'pin_code' => ['nullable', 'string', 'max:255'],
            'rfid' => ['nullable', 'string', 'max:50'],
            'role_id' => ['nullable', 'exists:roles,id'],
        ]);

        $user->update($fields);

        return redirect()->route('users')->with('success', 'User updated successfully.');
    }

    public function verify($id)
    {
        $user = User::findOrFail($id);

        $user->verified_at = now();
        $user->save();

        return redirect()->route('users')->with('success', 'User verified successfully.');
    }
}
