<?php

namespace App\Http\Controllers;

use App\Models\BorrowedKit;
use App\Http\Requests\StoreBorrowedKitRequest;
use App\Http\Requests\UpdateBorrowedKitRequest;
use App\Models\Kit;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowedKitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $borrowedKits = BorrowedKit::with(['kit', 'student'])
            ->whereHas('student', function ($query) use ($search) {
                $query->where('email', 'like', "%{$search}%");
            })
            ->orWhere(function ($query) use ($search) {
                $query->where('kit_id', 'like', "%{$search}%")
                    ->orWhere('quantity_borrowed', 'like', "%{$search}%")
                    ->orWhere('borrowed_at', 'like', "%{$search}%")
                    ->orWhere('due_date', 'like', "%{$search}%")
                    ->orWhere('returned_at', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('borrowed-kits.index', ['borrowedKits' => $borrowedKits]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowedKitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BorrowedKit $borrowedKit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BorrowedKit $borrowedKit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowedKitRequest $request, BorrowedKit $borrowedKit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BorrowedKit $borrowedKit)
    {
        //
    }
}
