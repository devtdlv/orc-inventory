@extends('layouts.app')

@section('title', $item->name)

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $item->name }}</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $item->description }}</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
            <a href="{{ route('items.edit', $item) }}" class="inline-block rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Edit</a>
            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-block rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500" onclick="return confirm('Are you sure you want to delete this item? This action cannot be undone.')">Delete</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Details</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        <span class="inline-block h-3 w-3 rounded-full mr-2" style="background-color: {{ $item->category->color }}"></span>
                        {{ $item->category->name }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock Level</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $item->stock_level }} / Min: {{ $item->min_stock_level }}
                        @if($item->isLowStock())
                            <span class="ml-2 text-red-600">⚠️ Low Stock</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $item->location ?? 'Not set' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Barcode</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $item->barcode }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        @if($item->is_consumable) Consumable @endif
                        @if($item->is_tool) Tool @endif
                    </dd>
                </div>
            </dl>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">QR Code</h2>
            <div class="flex justify-center">
                {!! $qrCode !!}
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('items.qr-code', $item) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">View Full Size</a>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Maintenance Logs</h2>
            <ul class="space-y-2">
                @forelse($item->maintenanceLogs->take(5) as $log)
                    <li class="text-sm">
                        <span class="font-medium">{{ $log->maintenance_type }}</span>
                        <span class="text-gray-500 dark:text-gray-400"> - {{ $log->performed_at->format('M d, Y') }}</span>
                    </li>
                @empty
                    <li class="text-sm text-gray-500 dark:text-gray-400">No maintenance logs</li>
                @endforelse
            </ul>
            <a href="{{ route('maintenance.create', ['item_id' => $item->id]) }}" class="mt-4 text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Add Maintenance</a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Checkouts</h2>
            <ul class="space-y-2">
                @forelse($item->checkouts->where('status', 'checked_out')->take(5) as $checkout)
                    <li class="text-sm">
                        <span class="font-medium">{{ $checkout->user->name }}</span>
                        <span class="text-gray-500 dark:text-gray-400"> - {{ $checkout->checked_out_at->format('M d, Y') }}</span>
                    </li>
                @empty
                    <li class="text-sm text-gray-500 dark:text-gray-400">No active checkouts</li>
                @endforelse
            </ul>
            @if($item->is_tool)
                <a href="{{ route('checkouts.create', ['item_id' => $item->id]) }}" class="mt-4 text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Check Out</a>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Consumables</h2>
            <ul class="space-y-2">
                @forelse($item->consumables->take(5) as $consumable)
                    <li class="text-sm">
                        <span class="font-medium">{{ $consumable->quantity_used }} used</span>
                        <span class="text-gray-500 dark:text-gray-400"> - {{ $consumable->used_at->format('M d, Y') }}</span>
                    </li>
                @empty
                    <li class="text-sm text-gray-500 dark:text-gray-400">No consumable usage</li>
                @endforelse
            </ul>
            @if($item->is_consumable)
                <a href="{{ route('consumables.create', ['item_id' => $item->id]) }}" class="mt-4 text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Record Usage</a>
            @endif
        </div>
    </div>
</div>
@endsection

