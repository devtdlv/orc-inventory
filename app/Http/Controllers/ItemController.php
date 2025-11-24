<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $query = Item::with('category');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->latest()->paginate(20);
        $categories = Category::all();

        return view('items.index', compact('items', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'barcode' => 'nullable|string|unique:items,barcode',
            'stock_level' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255',
            'is_consumable' => 'boolean',
            'is_tool' => 'boolean',
        ]);

        // Generate QR code if not provided
        if (empty($validated['qr_code'])) {
            $validated['qr_code'] = 'ORC-' . uniqid();
        }

        // Generate barcode if not provided
        if (empty($validated['barcode'])) {
            $validated['barcode'] = 'BC-' . uniqid();
        }

        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show(Item $item): View
    {
        $item->load(['category', 'maintenanceLogs.user', 'checkouts.user', 'consumables.user']);
        
        // Generate QR code SVG
        $qrCode = QrCode::size(200)->generate(route('items.show', $item));

        return view('items.show', compact('item', 'qrCode'));
    }

    public function edit(Item $item): View
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'barcode' => 'nullable|string|unique:items,barcode,' . $item->id,
            'stock_level' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255',
            'is_consumable' => 'boolean',
            'is_tool' => 'boolean',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Item deleted successfully.');
    }

    public function qrCode(Item $item)
    {
        $qrCode = QrCode::size(300)->generate(route('items.show', $item));
        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }
}
