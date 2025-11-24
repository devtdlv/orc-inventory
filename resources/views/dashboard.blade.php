@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Overview of your inventory</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="text-2xl">📦</div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Items</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['total_items'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="text-2xl">🏷️</div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Categories</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['total_categories'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="text-2xl">⚠️</div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Low Stock</dt>
                            <dd class="text-lg font-medium text-red-600 dark:text-red-400">{{ $stats['low_stock_items'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="text-2xl">🔧</div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Checked Out</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['checked_out_tools'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-5 lg:grid-cols-3">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Recent Items</h3>
                <div class="flow-root">
                    <ul class="-my-5 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recent_items as $item)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900">
                                            <span class="text-indigo-600 dark:text-indigo-300">📦</span>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            <a href="{{ route('items.show', $item) }}" class="hover:text-indigo-600">{{ $item->name }}</a>
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->category->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('items.show', $item) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">View</a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-sm text-gray-500 dark:text-gray-400">No items yet</li>
                        @endforelse
                    </ul>
                </div>
                @if($recent_items->count() > 0)
                    <div class="mt-4">
                        <a href="{{ route('items.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">View all items →</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Low Stock Items</h3>
                <div class="flow-root">
                    <ul class="-my-5 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($low_stock_items as $item)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-red-100 dark:bg-red-900">
                                            <span class="text-red-600 dark:text-red-300">⚠️</span>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            <a href="{{ route('items.show', $item) }}" class="hover:text-indigo-600">{{ $item->name }}</a>
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Stock: {{ $item->stock_level }} / Min: {{ $item->min_stock_level }}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('items.show', $item) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">View</a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-sm text-gray-500 dark:text-gray-400">No low stock items</li>
                        @endforelse
                    </ul>
                </div>
                @if($low_stock_items->count() > 0)
                    <div class="mt-4">
                        <a href="{{ route('items.index', ['filter' => 'low_stock']) }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">View all low stock →</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Checked Out Tools</h3>
                <div class="flow-root">
                    <ul class="-my-5 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($checked_out_items as $checkout)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900">
                                            <span class="text-blue-600 dark:text-blue-300">🔧</span>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            <a href="{{ route('items.show', $checkout->item) }}" class="hover:text-indigo-600">{{ $checkout->item->name }}</a>
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            By: {{ $checkout->user->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('checkouts.show', $checkout) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">View</a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-sm text-gray-500 dark:text-gray-400">No items checked out</li>
                        @endforelse
                    </ul>
                </div>
                @if($checked_out_items->count() > 0)
                    <div class="mt-4">
                        <a href="{{ route('checkouts.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">View all checkouts →</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

