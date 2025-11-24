@extends('layouts.app')

@section('title', 'Consumable Usage Details')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 max-w-2xl">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Consumable Usage Details</h1>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Item</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $consumable->item->name }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Quantity Used</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $consumable->quantity_used }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Used By</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $consumable->user->name }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Used At</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $consumable->used_at->format('M d, Y H:i') }}</dd>
        </div>
        @if($consumable->notes)
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $consumable->notes }}</dd>
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('consumables.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">← Back to Consumables</a>
    </div>
</div>
@endsection

