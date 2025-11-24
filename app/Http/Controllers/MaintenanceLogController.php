<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaintenanceLogController extends Controller
{
    public function index(): View
    {
        $logs = MaintenanceLog::with(['item.category', 'user'])
            ->latest('performed_at')
            ->paginate(20);

        return view('maintenance.index', compact('logs'));
    }

    public function create(Request $request): View
    {
        $item = $request->has('item_id') ? Item::findOrFail($request->item_id) : null;
        $items = Item::all();

        return view('maintenance.create', compact('item', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'maintenance_type' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'performed_at' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();

        MaintenanceLog::create($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance log created successfully.');
    }

    public function show(MaintenanceLog $maintenanceLog): View
    {
        $maintenanceLog->load(['item.category', 'user']);
        return view('maintenance.show', compact('maintenanceLog'));
    }

    public function edit(MaintenanceLog $maintenanceLog): View
    {
        $items = Item::all();
        return view('maintenance.edit', compact('maintenanceLog', 'items'));
    }

    public function update(Request $request, MaintenanceLog $maintenanceLog): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'maintenance_type' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'performed_at' => 'required|date',
        ]);

        $maintenanceLog->update($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance log updated successfully.');
    }

    public function destroy(MaintenanceLog $maintenanceLog): RedirectResponse
    {
        $maintenanceLog->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance log deleted successfully.');
    }
}
