<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $equipment = $query->latest('id')->paginate(12);

        $categories = Category::all();

        return view('catalog.index', compact('equipment', 'categories'));
    }

    public function show(Equipment $equipment)
    {
        $equipment->load('category');

        return view('catalog.show', compact('equipment'));
    }
}
