@extends('layouts.app')
@section('content')
    <h2 class="text-3xl font-bold text-center mb-8 text-gray-800 dark:text-gray-700 mt-2">Latest Blog Posts</h2>
    <form method="GET" action="{{ route('blog.index') }}" 
      class="mb-10 bg-white dark:bg-gray-900 p-6 rounded-xl shadow-lg max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6 ml-2 mr-2">

    <input type="text" name="tag" value="{{ request('tag') }}" placeholder="Filter by tag"
           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg
                  bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100
                  placeholder-gray-400 dark:placeholder-gray-500
                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                  transition duration-200"/>

    <input type="text" name="category" value="{{ request('category') }}" placeholder="Category"
           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg
                  bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100
                  placeholder-gray-400 dark:placeholder-gray-500
                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                  transition duration-200"/>

    <input type="text" name="author" value="{{ request('author') }}" placeholder="Author"
           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg
                  bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100
                  placeholder-gray-400 dark:placeholder-gray-500
                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                  transition duration-200"/>

    <div class="flex items-center space-x-4 lg:col-span-1 sm:col-span-2 col-span-1">
        <button type="submit" 
                class="flex-grow px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg
                       shadow-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            Apply Filters
        </button>
        <a href="{{ route('blog.index') }}" 
           class="text-indigo-600 hover:text-indigo-800 font-medium underline whitespace-nowrap">
           Clear
        </a>
    </div>
</form>


    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @if(session('success'))
            <div class="col-span-full mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($posts as $post)
            <article class="bg-indigo-50/40 dark:bg-slate-800 rounded-xl shadow-md border border-indigo-100 dark:border-slate-700 hover:shadow-lg transition p-4 flex flex-col justify-between">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-40 object-cover rounded-md mb-3">
                @endif

                @if($post->category)
                    <span class="text-xs uppercase tracking-wide text-indigo-700 dark:text-indigo-300 font-semibold mb-1">
                        {{ $post->category }}
                    </span>
                @endif

                <h3 class="text-lg font-bold text-gray-900 dark:text-white hover:text-indigo-700 dark:hover:text-indigo-400 transition">
                    <a href="{{ route('blog.show', $post->slug) }}">
                        {{ $post->title }}
                    </a>
                </h3>

                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">
                    By {{ $post->user->name }} • {{ $post->created_at->format('M d, Y') }}
                </div>

                <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">
                    {{ Str::limit(strip_tags($post->content), 100) }}
                </p>

                @if($post->tags)
                    <div class="flex flex-wrap gap-1 mb-3">
                        @foreach(explode(',', $post->tags) as $tag)
                            <a href="{{ route('blog.index', ['tag' => trim($tag)]) }}"
                               class="bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-indigo-200 text-xs px-2 py-0.5 rounded-full hover:underline">
                                {{ trim($tag) }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="mt-auto">
                    <a href="{{ route('blog.show', $post->slug) }}"
                       class="text-sm text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                        Read More →
                    </a>
                </div>

                @auth
                    @if(auth()->user()->hasAnyRole(['admin', 'editor']))
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('blog.edit', $post->id) }}"
                               class="flex-1 text-center text-xs px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">
                                Edit
                            </a>

                            <form action="{{ route('blog.destroy', $post->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this post?');"
                                  class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full text-xs px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </article>
        @empty
            <p class="col-span-full text-center text-gray-600 dark:text-gray-400">No posts available yet.</p>
        @endforelse

        <div class="col-span-full mt-6">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
