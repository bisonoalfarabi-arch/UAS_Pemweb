<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function myRentals()
    {
        $user = Auth::user();

        $rentals = Rental::with('equipment')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $stats = [
            'totalRentals'   => Rental::where('user_id', $user->id)->count(),
            'activeRentals'  => Rental::where('user_id', $user->id)->where('status', 'active')->count(),
            'pendingRentals' => Rental::where('user_id', $user->id)->where('status', 'pending')->count(),
            'totalSpent'     => Rental::where('user_id', $user->id)->where('status', 'completed')->sum('total_price'),
        ];

        return view('rentals.my', compact('rentals', 'stats'));
    }

    public function show(Rental $rental)
    {
        $user = Auth::user();

        if ($rental->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $rental->load(['equipment', 'user']);
        return view('rentals.show', compact('rental'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'rental_date'  => 'required|date|after_or_equal:today',
            'return_date'  => 'required|date|after:rental_date',
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);

        if ($equipment->stock < 1) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $rentalDate = new \DateTime($request->rental_date);
        $returnDate = new \DateTime($request->return_date);
        $totalDays  = max(1, $returnDate->diff($rentalDate)->days);

        $totalPrice = $equipment->price_per_day * $totalDays;

        Rental::create([
            'user_id'      => Auth::id(),
            'equipment_id' => $equipment->id,
            'rental_date'  => $request->rental_date,
            'return_date'  => $request->return_date,
            'total_days'   => $totalDays,
            'total_price'  => $totalPrice,
            'status'       => 'pending',
        ]);

        return redirect()->route('rentals.my')
            ->with('success', 'Penyewaan berhasil dibuat! Menunggu konfirmasi admin.');
    }

    public function cancel(Rental $rental)
    {
        $user = Auth::user();

        if ($rental->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if ($rental->status !== 'pending') {
            return back()->with('error', 'Hanya penyewaan pending yang dapat dibatalkan.');
        }

        $rental->update(['status' => 'cancelled']);

        return back()->with('success', 'Penyewaan berhasil dibatalkan.');
    }
}
