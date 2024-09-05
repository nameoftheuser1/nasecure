<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class InstructorController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $instructorsQuery = User::whereHas('role', function ($query) {
            $query->where('name', 'instructor');
        });

        if ($search) {
            $instructorsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $instructors = $instructorsQuery->paginate(10);

        return view('instructors.index', compact('instructors'));
    }

    public function show($id)
    {
        $instructor = User::with(['sections', 'schedules'])
            ->whereHas('role', function ($query) {
                $query->where('name', 'instructor');
            })
            ->findOrFail($id);

        return view('instructors.show', compact('instructor'));
    }
}
