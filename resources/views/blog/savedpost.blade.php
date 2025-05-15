@extends('layouts.app')

@section('content')
    <h2 class="text-3xl font-bold mb-6 text-center">Your Saved Posts</h2>

    @if ($bookmarks->count() > 0)
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mr-2 ml-2">
            @foreach ($bookmarks as $bookmark)
                @php
                    $post = $bookmark->blogpost;
                @endphp

                @if ($post)
                    <article class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex flex-col">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="rounded mb-4 h-40 object-cover w-full">
                        @endif

                        <h3 class="text-xl font-semibold mb-2">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                {{ $post->title }}
                            </a>
                        </h3>

                        <p class="text-gray-700 dark:text-gray-300 flex-grow">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>

                        <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                            By {{ $post->user->name }} • {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </article>
                @endif
            @endforeach
        </div>

        <div class="mt-6 max-w-7xl mx-auto">
            {{ $bookmarks->links() }}
        </div>
    @else
        <p class="text-center text-gray-600 dark:text-gray-400">You haven't saved any posts yet.</p>
    @endif
@endsection
