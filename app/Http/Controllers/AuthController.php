<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Rules\EmailDomain;
use Illuminate\Support\Str;
use App\Rules\ValidPhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $fields = $request->validate([
            'first_name' => ['required', 'max:50', 'min:3', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'max:50', 'min:3', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'max:255', 'email', 'unique:users,email,' . $user->id, new EmailDomain],
            'contact' => ['required', 'max:11', new ValidPhoneNumber],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'img_url' => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'rfid' => ['nullable', 'max:30'],
            'pin_code' => ['nullable', 'max:10']
        ]);

        if ($request->hasFile('img_url')) {
            if ($user->img_url) {
                Storage::disk('public')->delete($user->img_url);
            }

            $file = $request->file('img_url');
            $path = $file->store('profile_pictures', 'public');

            $fields['img_url'] = $path;
        }

        if ($request->filled('password')) {
            $fields['password'] = Hash::make($request->password);
        } else {
            unset($fields['password']);
        }

        //dont mind this error "if its working then its not a problem"
        $user->update($fields);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => ['required', 'max:50', 'min:3', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'max:50', 'min:3', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'max:50', 'email', 'unique:users', new EmailDomain],
            'contact' => ['required', 'max:11', new ValidPhoneNumber],
            'password' => ['required', 'min:8', 'confirmed', 'max:50'],
        ]);

        $fields['role_id'] = 1;

        $user = User::create($fields);

        return redirect()->intended('/');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $rules = [
            'email' => ['required', 'max:255'],
            'password' => ['required'],
        ];

        if ($email !== 'admin') {
            $rules['email'][] = new EmailDomain;
        }

        $fields = $request->validate($rules);

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->intended('/');
        } else {
            return back()->withInput()->withErrors([
                'email' => 'Invalid email or password.',
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

    public function resetPassword(Request $request, User $user)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $token = Str::random(60);

        $resetUrl = url('/password/reset?token=' . $token);

        $data = [
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()->toDateTimeString(),
            'reset_url' => $resetUrl,
        ];

        $filePath = storage_path('app/password_resets.json');

        $existingData = File::exists($filePath) ? json_decode(File::get($filePath), true) : [];
        $existingData[] = $data;

        File::put($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

        return response()->json([
            'success' => 'Password reset data has been recorded.',
            'reset_url' => $resetUrl,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $filePath = storage_path('app/password_resets.json');
        $data = json_decode(file_get_contents($filePath), true);

        $resetEntry = collect($data)->firstWhere('token', $request->token);

        if (!$resetEntry) {
            return redirect()->back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        $user = User::where('email', $resetEntry['email'])->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $data = array_filter($data, fn ($entry) => $entry['token'] !== $request->token);
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('login')->with('success', 'Password has been reset successfully.');
    }
}
