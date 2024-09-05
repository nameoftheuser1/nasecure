<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $schedulesQuery = Schedule::query()
            ->with('user');

        if ($search) {
            $schedulesQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('day', 'like', "%{$search}%");
            });
        }

        $schedules = $schedulesQuery->paginate(10);

        return view('schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructors = User::whereHas('role', function ($query) {
            $query->where('name', 'instructor');
        })->get();

        return view('schedules.create', compact('instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'day' => ['required', 'string', 'max:10'],
            'time_in' => ['required', 'date_format:H:i'],
            'time_out' => ['required', 'date_format:H:i'],
        ]);

        Schedule::create($fields);

        return redirect()->route('schedules.index')->with('success', 'Schedule added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'instructor');
        })->get();

        return view('schedules.edit', compact('schedule', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $fields = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'day' => ['required', 'string', 'max:10'],
            'time_in' => ['required', 'date_format:H:i'],
            'time_out' => ['required', 'date_format:H:i'],
        ]);

        $schedule->update($fields);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
