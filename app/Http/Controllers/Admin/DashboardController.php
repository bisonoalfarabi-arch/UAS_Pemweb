<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rental;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers'      => User::count(),
            'totalRentals'    => Rental::count(),
            'totalEquipment'  => Equipment::count(),
            'activeRentals'   => Rental::where('status', 'active')->count(),
            'pendingRentals'  => Rental::where('status', 'pending')->count(),
            'totalRevenue'    => Rental::where('status', 'completed')->sum('total_price'),
        ];

        // Pakai latest('id') biar tidak tergantung created_at yang bisa NULL
        $recentRentals = Rental::with(['user', 'equipment'])
            ->latest('id')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRentals'));
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function rentalReport(Request $request)
    {
        $query = Rental::with(['user', 'equipment'])->latest();

        if ($request->filled('start_date')) {
            $query->whereDate('rental_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('rental_date', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->whereHas('user', function ($uq) use ($s) {
                    $uq->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%");
                })->orWhereHas('equipment', function ($eq) use ($s) {
                    $eq->where('name', 'like', "%{$s}%");
                });
            });
        }

        $rentals = $query->paginate(15);

        $summary = [
            'total_transactions' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'active' => (clone $query)->where('status', 'active')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'total_amount_all' => (clone $query)->sum('total_price'),
            'total_amount_completed' => (clone $query)->where('status', 'completed')->sum('total_price'),
        ];

        return view('admin.reports.rentals', compact('rentals', 'summary'));
    }

    public function revenueReport(Request $request)
    {
        $group = $request->get('group', 'day');

        $query = Rental::query()->where('status', 'completed');

        if ($request->filled('start_date')) {
            $query->whereDate('rental_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('rental_date', '<=', $request->end_date);
        }

        $rows = $query->get(['rental_date', 'total_price']);

        $bucket = [];
        foreach ($rows as $r) {
            $date = Carbon::parse($r->rental_date);
            $key = $group === 'month' ? $date->format('Y-m') : $date->format('Y-m-d');
            $label = $group === 'month' ? $date->translatedFormat('F Y') : $date->format('d/m/Y');

            if (!isset($bucket[$key])) {
                $bucket[$key] = ['label' => $label, 'count' => 0, 'total' => 0];
            }
            $bucket[$key]['count'] += 1;
            $bucket[$key]['total'] += (float) $r->total_price;
        }

        ksort($bucket);
        $revenues = array_values($bucket);

        $totalRevenue = array_sum(array_column($revenues, 'total'));
        $completedCount = array_sum(array_column($revenues, 'count'));
        $avg = $completedCount > 0 ? ($totalRevenue / $completedCount) : 0;

        $summary = [
            'total_revenue' => $totalRevenue,
            'completed_count' => $completedCount,
            'avg_revenue' => $avg,
        ];

        return view('admin.reports.revenue', compact('revenues', 'summary'));
    }
}
