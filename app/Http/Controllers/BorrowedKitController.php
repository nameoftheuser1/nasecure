<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBorrowedKitRequest;
use App\Models\BorrowedKit;
use App\Models\Kit;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BorrowedKitController extends Controller
{
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

    public function borrow(Request $request)
    {
        $search = $request->input('search');
        $kits = Kit::query()
            ->when($search, function ($query, $search) {
                return $query->where('kit_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(9);

        return view('borrowed-kits.borrow', ['kits' => $kits]);
    }

    public function proceedToBorrow(Request $request)
    {
        $cartData = json_decode($request->input('cart'), true);

        if (empty($cartData)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $studentEmail = $request->input('email');
        $student = Student::where('email', $studentEmail)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student with this email does not exist.');
        }

        foreach ($cartData as $kitId => $details) {
            $kit = Kit::find($kitId);

            if (!$kit) {
                return redirect()->back()->with('error', "Kit with ID {$kitId} not found.");
            }

            if ($kit->quantity < $details['quantity']) {
                return redirect()->back()->with('error', "Not enough quantity available for {$kit->kit_name}.");
            }

            BorrowedKit::create([
                'kit_id' => $kitId,
                'student_id' => $student->id,
                'quantity_borrowed' => $details['quantity'],
                'borrowed_at' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(5),
                'status' => 'borrowed',
            ]);

            $kit->quantity -= $details['quantity'];
            $kit->save();
        }

        session()->forget('cart');

        return redirect()->back()->with('success', 'Kits borrowed successfully!');
    }

    public function fetchBorrowedKits(Request $request)
    {
        $email = $request->query('email');

        $student = Student::where('email', $email)->first();

        if (!$student) {
            return response()->json([]);
        }

        $borrowedKits = BorrowedKit::where('student_id', $student->id)
            ->with('kit')
            ->get()
            ->map(function ($borrowedKit) {
                return [
                    'kit_id' => $borrowedKit->kit->id,
                    'kit_name' => $borrowedKit->kit->kit_name,
                    'quantity_borrowed' => $borrowedKit->quantity_borrowed,
                ];
            });

        return response()->json($borrowedKits);
    }

    public function showReturnForm()
    {
        return view('borrowed-kits.return');
    }

    public function processReturn(Request $request)
    {
        $studentEmail = $request->input('email');
        $kitId = $request->input('kit_id');
        $quantityToReturn = $request->input('quantity');

        $student = Student::where('email', $studentEmail)->first();
        $borrowedKit = BorrowedKit::where('student_id', $student->id)->where('kit_id', $kitId)->first();

        if (!$borrowedKit || $borrowedKit->quantity_borrowed < $quantityToReturn) {
            return redirect()->back()->with('error', 'Invalid return quantity.');
        }

        $borrowedKit->quantity_borrowed -= $quantityToReturn;
        if ($borrowedKit->quantity_borrowed == 0) {
            $borrowedKit->delete();
        } else {
            $borrowedKit->save();
        }

        $kit = Kit::find($kitId);
        $kit->quantity += $quantityToReturn;
        $kit->save();

        return redirect()->route('borrowed-kits.return')->with('success', 'Kit returned successfully.');
    }


    public function returnKits(Request $request)
    {
        $email = $request->input('email');
        $kits = $request->input('kits');

        $student = Student::where('email', $email)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student with this email does not exist.');
        }

        foreach ($kits as $kitId => $quantityToReturn) {
            $borrowedKit = BorrowedKit::where('kit_id', $kitId)
                ->where('student_id', $student->id)
                ->where('status', 'borrowed')
                ->first();

            if (!$borrowedKit) {
                continue;
            }

            if ($quantityToReturn > $borrowedKit->quantity_borrowed) {
                return redirect()->back()->with('error', "Return quantity for {$borrowedKit->kit->kit_name} exceeds the borrowed quantity.");
            }

            $kit = $borrowedKit->kit;
            $kit->quantity += $quantityToReturn;
            $kit->save();

            $borrowedKit->quantity_borrowed -= $quantityToReturn;

            if ($borrowedKit->quantity_borrowed == 0) {
                $borrowedKit->status = 'returned';
                $borrowedKit->returned_at = Carbon::now();
            }

            $borrowedKit->save();
        }

        return redirect()->back()->with('success', 'Kits returned successfully!');
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
