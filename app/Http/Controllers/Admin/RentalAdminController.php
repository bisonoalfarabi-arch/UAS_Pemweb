<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with(['user', 'equipment'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('rental_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('rental_date', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('equipment', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->has('export')) {
            return back()->with('info', 'Fitur export akan segera tersedia.');
        }

        $rentals = $query->paginate(15);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load(['user', 'equipment']);

        $userStats = [
            'total_rentals'      => $rental->user->rentals()->count(),
            'completed_rentals'  => $rental->user->rentals()->where('status', 'completed')->count(),
            'total_spent'        => $rental->user->rentals()->where('status', 'completed')->sum('total_price'),
        ];

        return view('admin.rentals.show', compact('rental', 'userStats'));
    }

    public function approve(Rental $rental)
    {
        if ($rental->status !== 'pending') {
            return back()->with('error', 'Hanya penyewaan pending yang bisa disetujui.');
        }

        if ($rental->equipment->stock < 1) {
            return back()->with('error', 'Stok peralatan tidak mencukupi.');
        }

        $rental->update(['status' => 'active']);
        $rental->equipment->decrement('stock', 1);

        return back()->with('success', 'Penyewaan berhasil disetujui.');
    }

    public function reject(Rental $rental)
    {
        if ($rental->status !== 'pending') {
            return back()->with('error', 'Hanya penyewaan pending yang bisa ditolak.');
        }

        $rental->update(['status' => 'rejected']);
        return back()->with('success', 'Penyewaan berhasil ditolak.');
    }

    public function complete(Rental $rental)
    {
        if ($rental->status !== 'active') {
            return back()->with('error', 'Hanya penyewaan active yang bisa diselesaikan.');
        }

        $rental->update(['status' => 'completed']);
        $rental->equipment->increment('stock', 1);

        return back()->with('success', 'Penyewaan berhasil diselesaikan.');
    }

    public function destroy(Rental $rental)
    {
        if ($rental->status === 'active') {
            $rental->equipment->increment('stock', 1);
        }

        $rental->delete();
        return back()->with('success', 'Penyewaan berhasil dihapus.');
    }
}
