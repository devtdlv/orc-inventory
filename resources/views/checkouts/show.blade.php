@extends('layouts.app')

@section('title', 'Checkout Details')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 max-w-2xl">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Checkout Details</h1>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Item</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $checkout->item->name }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">User</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $checkout->user->name }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Checked Out</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $checkout->checked_out_at->format('M d, Y H:i') }}</dd>
        </div>
        @if($checkout->checked_in_at)
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Checked In</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $checkout->checked_in_at->format('M d, Y H:i') }}</dd>
            </div>
        @endif
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
            <dd class="mt-1 text-sm">
                @if($checkout->status === 'checked_out')
                    <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">Checked Out</span>
                @else
                    <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Checked In</span>
                @endif
            </dd>
        </div>
        @if($checkout->notes)
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $checkout->notes }}</dd>
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('checkouts.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">← Back to Checkouts</a>
    </div>
</div>
@endsection

