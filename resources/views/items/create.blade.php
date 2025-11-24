@extends('layouts.app')

@section('title', 'Create Item')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 max-w-2xl">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Create Item</h1>

    <form action="{{ route('items.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
            <select name="category_id" id="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="stock_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock Level</label>
                <input type="number" name="stock_level" id="stock_level" required value="{{ old('stock_level', 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label for="min_stock_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Min Stock Level</label>
                <input type="number" name="min_stock_level" id="min_stock_level" required value="{{ old('min_stock_level', 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div class="flex items-center space-x-6">
            <div class="flex items-center">
                <input type="checkbox" name="is_consumable" id="is_consumable" value="1" {{ old('is_consumable') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="is_consumable" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Is Consumable</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_tool" id="is_tool" value="1" {{ old('is_tool', true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="is_tool" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Is Tool</label>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('items.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">Cancel</a>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Create</button>
        </div>
    </form>
</div>
@endsection

