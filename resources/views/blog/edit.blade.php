@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-black mb-10 text-center">
        Edit Blog Post
    </h1>

    <form method="POST" action="{{ route('blog.update', $blogPost->id) }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 space-y-6">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title', $blogPost->title) }}" required
                class="w-full dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-500 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Content --}}
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Content</label>
            <textarea id="content" name="content" rows="8" required
                class="w-full dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-500 @error('content') border-red-500 @enderror">{{ old('content', $blogPost->content) }}</textarea>
            @error('content')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category --}}
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
            <input id="category" name="category" type="text" value="{{ old('category', $blogPost->category) }}"
                class="w-full dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-500 @error('category') border-red-500 @enderror">
            @error('category')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tags --}}
        <div>
            <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags (comma separated)</label>
            <input id="tags" name="tags" type="text" value="{{ old('tags', $blogPost->tags) }}"
                class="w-full dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-500 @error('tags') border-red-500 @enderror">
            @error('tags')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Image --}}
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image</label>

            @if($blogPost->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $blogPost->image) }}" alt="Current Image" class="w-48 rounded-lg shadow-md">
                </div>
            @endif

            <input id="image" name="image" type="file" accept="image/*"
                class="w-full text-gray-700 dark:text-white dark:bg-gray-800 dark:border-gray-700 rounded-lg file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700 @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Leave empty if you don't want to change the image.</p>
        </div>

        {{-- Submit --}}
        <div class="text-center">
            <button type="submit"
                class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                Update Post
            </button>
        </div>
    </form>
</div>
@endsection
