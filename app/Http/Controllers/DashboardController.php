<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Checkout;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => Item::count(),
            'total_categories' => Category::count(),
            'low_stock_items' => Item::whereColumn('stock_level', '<=', 'min_stock_level')->count(),
            'checked_out_tools' => Checkout::where('status', 'checked_out')->count(),
        ];

        $recent_items = Item::with('category')
            ->latest()
            ->take(10)
            ->get();

        $low_stock_items = Item::with('category')
            ->whereColumn('stock_level', '<=', 'min_stock_level')
            ->latest()
            ->take(5)
            ->get();

        $checked_out_items = Checkout::with(['item.category', 'user'])
            ->where('status', 'checked_out')
            ->latest('checked_out_at')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_items', 'low_stock_items', 'checked_out_items'));
    }
}
