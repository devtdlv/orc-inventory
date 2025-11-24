@extends('layouts.app')

@section('title', 'Add Maintenance Log')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 max-w-2xl">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Add Maintenance Log</h1>

    <form action="{{ route('maintenance.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="item_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
            <select name="item_id" id="item_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Select an item</option>
                @foreach($items as $itemOption)
                    <option value="{{ $itemOption->id }}" {{ ($item && $item->id == $itemOption->id) ? 'selected' : '' }}>{{ $itemOption->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="maintenance_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Maintenance Type</label>
            <input type="text" name="maintenance_type" id="maintenance_type" required value="{{ old('maintenance_type') }}" placeholder="e.g., Repair, Inspection, Cleaning" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
            <label for="performed_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Performed At</label>
            <input type="datetime-local" name="performed_at" id="performed_at" required value="{{ old('performed_at', now()->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
            <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cost</label>
            <input type="number" name="cost" id="cost" step="0.01" min="0" value="{{ old('cost') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('notes') }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('maintenance.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">Cancel</a>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Create</button>
        </div>
    </form>
</div>
@endsection

