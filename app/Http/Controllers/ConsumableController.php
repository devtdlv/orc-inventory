<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConsumableController extends Controller
{
    public function index(): View
    {
        $consumables = Consumable::with(['item.category', 'user'])
            ->latest('used_at')
            ->paginate(20);

        return view('consumables.index', compact('consumables'));
    }

    public function create(Request $request): View
    {
        $item = $request->has('item_id') ? Item::findOrFail($request->item_id) : null;
        $items = Item::where('is_consumable', true)->get();

        return view('consumables.create', compact('item', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity_used' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'used_at' => 'required|date',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if (!$item->is_consumable) {
            return back()->withErrors(['item_id' => 'This item is not marked as consumable.']);
        }

        if ($item->stock_level < $validated['quantity_used']) {
            return back()->withErrors(['quantity_used' => 'Insufficient stock. Available: ' . $item->stock_level]);
        }

        $validated['user_id'] = auth()->id();

        Consumable::create($validated);

        // Update stock level
        $item->decrement('stock_level', $validated['quantity_used']);

        return redirect()->route('consumables.index')
            ->with('success', 'Consumable usage recorded successfully.');
    }

    public function show(Consumable $consumable): View
    {
        $consumable->load(['item.category', 'user']);
        return view('consumables.show', compact('consumable'));
    }

    public function destroy(Consumable $consumable): RedirectResponse
    {
        // Restore stock if needed
        $item = $consumable->item;
        $item->increment('stock_level', $consumable->quantity_used);

        $consumable->delete();

        return redirect()->route('consumables.index')
            ->with('success', 'Consumable record deleted successfully.');
    }
}
