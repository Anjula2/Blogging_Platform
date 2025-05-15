@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="max-w-4xl mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8 text-center" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-black text-center leading-tight">
            {{ $post->title }}
        </h1>
        <p class="text-center text-gray-500 dark:text-gray-600 mt-2">
            By <span class="font-semibold">{{ $post->user->name }}</span> &middot; {{ $post->created_at->format('M d, Y') }}
        </p>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($post->image)
            <figure class="mb-8">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg shadow-md">
            </figure>
        @endif

        <article class="prose prose-lg max-w-full mx-auto mb-12 dark:prose-invert  text-gray-500 dark:text-gray-600">
            {!! nl2br(e($post->content)) !!}
        </article>

        @auth
            <section class="flex flex-wrap items-center justify-center gap-6 mb-12">
                <form method="POST" action="{{ route('blog.like', $post->slug) }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2 rounded-md bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 font-medium transition">
                        👍 Like <span class="ml-2 font-semibold">{{ $post->likes->count() }}</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('blog.bookmark', $post->slug) }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2 rounded-md bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 font-medium transition">
                        📌 Save for Later
                    </button>
                </form>
            </section>
        @else
            <p class="mb-12 text-center text-gray-600 dark:text-gray-400">
                Please <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">login</a> to like or save posts.
            </p>
        @endauth

        <section class="mb-16 max-w-4xl mx-auto">
            <h2 class="text-3xl font-semibold mb-6 dark:text-black">Comments ({{ $post->comments->count() }})</h2>

            @auth
                <form action="{{ route('blog.comment', $post->slug) }}" method="POST" class="mb-8">
                    @csrf
                    <label for="comment" class="sr-only">Write your comment</label>
                    <textarea id="comment" name="comment" rows="4" required
                        class="w-full rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white p-4 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Write your comment here..."></textarea>
                    <button type="submit"
                        class="mt-3 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold transition">
                        Post Comment
                    </button>
                </form>
            @else
                <p class="mb-6 text-gray-600 dark:text-gray-700">
                    Please <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">login</a> to post a comment.
                </p>
            @endauth

            <div class="space-y-6">
                @forelse ($post->comments as $comment)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <p class="text-gray-800 dark:text-gray-800 leading-relaxed">{{ $comment->comment }}</p>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            — <span class="font-semibold">{{ $comment->user->name }}</span> on {{ $comment->created_at->format('M d, Y \a\t H:i') }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-400 italic">No comments yet. Be the first to comment!</p>
                @endforelse
            </div>
        </section>

        <div class="text-center mb-16">
            <a href="{{ route('blog.index') }}" class="inline-block text-indigo-600 hover:underline text-lg font-medium">
                &larr; Back to all posts
            </a>
        </div>

    </main>

@endsection
