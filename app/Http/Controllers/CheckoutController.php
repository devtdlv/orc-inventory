<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View
    {
        $checkouts = Checkout::with(['item.category', 'user', 'checkedOutBy'])
            ->latest('checked_out_at')
            ->paginate(20);

        return view('checkouts.index', compact('checkouts'));
    }

    public function create(Request $request): View
    {
        $item = $request->has('item_id') ? Item::findOrFail($request->item_id) : null;
        $items = Item::where('is_tool', true)->get();
        $users = User::all();

        return view('checkouts.create', compact('item', 'items', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        // Check if item is already checked out
        $isCheckedOut = Checkout::where('item_id', $validated['item_id'])
            ->where('status', 'checked_out')
            ->exists();

        if ($isCheckedOut) {
            return back()->withErrors(['item_id' => 'This item is already checked out.']);
        }

        $validated['checked_out_by'] = auth()->id();
        $validated['checked_out_at'] = now();
        $validated['status'] = 'checked_out';

        Checkout::create($validated);

        return redirect()->route('checkouts.index')
            ->with('success', 'Item checked out successfully.');
    }

    public function show(Checkout $checkout): View
    {
        $checkout->load(['item.category', 'user', 'checkedOutBy', 'checkedInBy']);
        return view('checkouts.show', compact('checkout'));
    }

    public function checkIn(Checkout $checkout): RedirectResponse
    {
        if ($checkout->status === 'checked_in') {
            return back()->withErrors(['error' => 'This item is already checked in.']);
        }

        $checkout->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
            'checked_in_by' => auth()->id(),
        ]);

        return redirect()->route('checkouts.index')
            ->with('success', 'Item checked in successfully.');
    }

    public function destroy(Checkout $checkout): RedirectResponse
    {
        $checkout->delete();

        return redirect()->route('checkouts.index')
            ->with('success', 'Checkout record deleted successfully.');
    }
}
