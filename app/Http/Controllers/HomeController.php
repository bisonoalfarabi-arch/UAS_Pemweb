<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredEquipment = Equipment::with('category')
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredEquipment', 'categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
