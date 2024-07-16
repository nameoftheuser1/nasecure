<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = Carbon::now()->startOfMonth();

        if ($request->has('month')) {
            $currentMonth = Carbon::parse($request->input('month'))->startOfMonth();
        }

        $dates = collect(range(0, $currentMonth->daysInMonth - 1))
            ->map(function ($day) use ($currentMonth) {
                return $currentMonth->copy()->addDays($day);
            });

        return view('dashboard.index', compact('dates', 'currentMonth'));
    }
}
