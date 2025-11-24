@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h1>
            @if($category->description)
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $category->description }}</p>
            @endif
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
            <a href="{{ route('categories.edit', $category) }}" class="inline-block rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Edit</a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-block rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500" onclick="return confirm('Are you sure you want to delete this category? All items in this category will also be deleted.')">Delete</button>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Category Details</h2>
        <dl class="space-y-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Color</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    <span class="inline-block h-6 w-6 rounded-full mr-2" style="background-color: {{ $category->color }}"></span>
                    {{ $category->color }}
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Items Count</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $category->items->count() }}</dd>
            </div>
        </dl>
    </div>

    @if($category->items->count() > 0)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Items in this Category</h2>
                <div class="flow-root">
                    <ul class="-my-5 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($category->items as $item)
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
                                            Stock: {{ $item->stock_level }}
                                            @if($item->isLowStock())
                                                <span class="text-red-600">⚠️ Low Stock</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('items.show', $item) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">View</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">No items in this category yet.</p>
            <a href="{{ route('items.create', ['category_id' => $category->id]) }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Add an item to this category</a>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">← Back to Categories</a>
    </div>
</div>
@endsection

