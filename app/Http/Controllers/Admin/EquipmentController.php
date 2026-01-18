<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with('category');

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'available':
                    $query->where('stock', '>', 5);
                    break;
                case 'low':
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                    break;
                case 'out':
                    $query->where('stock', '=', 0);
                    break;
            }
        }

        // Sorting (hindari default latest() yang tergantung created_at bisa NULL)
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        $equipment = $query->paginate(15);

        // Statistics
        $totalEquipment      = Equipment::count();
        $availableEquipment  = Equipment::where('stock', '>', 5)->count();
        $lowStockEquipment   = Equipment::where('stock', '>', 0)->where('stock', '<=', 5)->count();
        $outOfStockEquipment = Equipment::where('stock', 0)->count();

        $categories = Category::all();

        return view('admin.equipment.index', compact(
            'equipment',
            'categories',
            'totalEquipment',
            'availableEquipment',
            'lowStockEquipment',
            'outOfStockEquipment'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.equipment.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price_per_day'=> 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('equipment', 'public');
        }

        Equipment::create($validated);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function edit(Equipment $equipment)
    {
        $categories = Category::all();
        return view('admin.equipment.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price_per_day'=> 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($equipment->image && Storage::disk('public')->exists($equipment->image)) {
                Storage::disk('public')->delete($equipment->image);
            }
            $validated['image'] = $request->file('image')->store('equipment', 'public');
        }

        $equipment->update($validated);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Peralatan berhasil diperbarui.');
    }

    public function destroy(Equipment $equipment)
    {
        if ($equipment->rentals()->whereIn('status', ['active', 'pending'])->exists()) {
            return back()->with('error', 'Tidak dapat menghapus peralatan yang memiliki penyewaan aktif.');
        }

        if ($equipment->image && Storage::disk('public')->exists($equipment->image)) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return back()->with('success', 'Peralatan berhasil dihapus.');
    }
}
