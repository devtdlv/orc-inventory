@extends('layouts.app')

@section('title', 'Maintenance Log Details')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 max-w-2xl">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Maintenance Log Details</h1>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Item</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $maintenanceLog->item->name }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $maintenanceLog->maintenance_type }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Performed At</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $maintenanceLog->performed_at->format('M d, Y H:i') }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cost</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($maintenanceLog->cost ?? 0, 2) }}</dd>
        </div>
        @if($maintenanceLog->notes)
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $maintenanceLog->notes }}</dd>
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('maintenance.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">← Back to Maintenance Logs</a>
    </div>
</div>
@endsection

