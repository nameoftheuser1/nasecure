<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBorrowedKitRequest;
use App\Models\BorrowedKit;
use App\Models\Kit;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BorrowedKitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $borrowedKits = BorrowedKit::with('kit')
            ->where('borrower_name', 'like', "%{$search}%")
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

        $borrowerName = $request->input('borrower_name');


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
                'borrower_name' => $borrowerName,
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
        $borrowerName = $request->query('borrower_name');

        $borrowedKits = BorrowedKit::where('borrower_name', 'like', "%{$borrowerName}%")
            ->with('kit')
            ->select('kit_id', DB::raw('SUM(quantity_borrowed) as total_quantity_borrowed'))
            ->groupBy('kit_id')
            ->get()
            ->map(function ($borrowedKit) {
                return [
                    'kit_id' => $borrowedKit->kit->id,
                    'kit_name' => $borrowedKit->kit->kit_name,
                    'quantity_borrowed' => $borrowedKit->total_quantity_borrowed,
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
        $borrowerName = $request->input('borrower_name');
        $kitId = $request->input('kit_id');
        $quantityToReturn = $request->input('quantity');

        $borrowedKit = BorrowedKit::where('borrower_name', $borrowerName)
            ->where('kit_id', $kitId)
            ->first();

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
        $borrowerName = $request->input('borrower_name');
        $kits = $request->input('kits');

        foreach ($kits as $kitId => $quantityToReturn) {
            $borrowedKits = BorrowedKit::where('kit_id', $kitId)
                ->where('borrower_name', $borrowerName)
                ->where('status', 'borrowed')
                ->orderBy('id', 'asc')
                ->get();

            $remainingToReturn = $quantityToReturn;

            foreach ($borrowedKits as $borrowedKit) {
                if ($remainingToReturn <= 0) {
                    break;
                }

                $returnableQuantity = min($remainingToReturn, $borrowedKit->quantity_borrowed);

                $borrowedKit->quantity_borrowed -= $returnableQuantity;
                $remainingToReturn -= $returnableQuantity;

                if ($borrowedKit->quantity_borrowed == 0) {
                    $borrowedKit->status = 'returned';
                    $borrowedKit->returned_at = Carbon::now();
                    $borrowedKit->save();
                } else {
                    $borrowedKit->save();
                }

                $kit = Kit::find($kitId);
                $kit->quantity += $returnableQuantity;
                $kit->save();
            }

            if ($remainingToReturn > 0) {
                return redirect()->back()->with('error', "Return quantity for Kit ID {$kitId} exceeds the total borrowed quantity.");
            }
        }

        return redirect()->back()->with('success', 'Kits returned successfully!');
    }
}
