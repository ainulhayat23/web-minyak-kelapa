<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $activeProducts = Product::where('is_active', true)->count();

        $outOfStockProducts = Product::where('stock', 0)->count();

        $totalStock = Product::sum('stock');

        $latestProducts = Product::latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'activeProducts',
            'outOfStockProducts',
            'totalStock',
            'latestProducts'
        ));
    }
}