@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <h1 class="text-4xl font-extrabold text-gray-800 dark:text-gray-700 mb-8">
        Create New Blog Post
    </h1>

    <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data" class="space-y-8 bg-white dark:bg-gray-900 p-8 rounded-lg shadow-md">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}" required
                class="w-full border dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Content --}}
        <div>
            <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Content</label>
            <textarea id="content" name="content" rows="8" required
                class="w-full border dark:border-gray-700 rounded-lg px-4 py-2 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category --}}
        <div>
            <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</label>
            <input id="category" name="category" type="text" value="{{ old('category') }}"
                class="w-full border dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white @error('category') border-red-500 @enderror">
            @error('category')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tags --}}
        <div>
            <label for="tags" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tags (comma separated)</label>
            <input id="tags" name="tags" type="text" value="{{ old('tags') }}"
                class="w-full border dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white @error('tags') border-red-500 @enderror">
            @error('tags')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Image Upload --}}
        <div>
            <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Image</label>
            <input id="image" name="image" type="file" accept="image/*"
                class="block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-md file:bg-blue-600 file:text-white hover:file:bg-blue-700 @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                Publish Post
            </button>
        </div>
    </form>
    <div>
        <a href="{{ route('admin.index') }}" class="text-indigo-600 hover:underline">&larr; Back to Admin Dashboard</a>
    </di>
</div>
@endsection
