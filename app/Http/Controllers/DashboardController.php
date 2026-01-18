<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Rental;
use App\Models\Equipment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'totalRentals'     => Rental::where('user_id', $user->id)->count(),
            'activeRentals'    => Rental::where('user_id', $user->id)->where('status', 'active')->count(),
            'pendingRentals'   => Rental::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completedRentals' => Rental::where('user_id', $user->id)->where('status', 'completed')->count(),
            'totalSpent'       => Rental::where('user_id', $user->id)->where('status', 'completed')->sum('total_price'),
        ];

        // Lebih tepat urut dari rental_date, fallback ke id
        $recentRentals = Rental::with('equipment')
            ->where('user_id', $user->id)
            ->orderByDesc('rental_date')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        // Jangan pakai scope available() kalau belum ada
        $recommendedEquipment = Equipment::where('stock', '>', 0)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('dashboard', compact('stats', 'recentRentals', 'recommendedEquipment'));
    }
}
