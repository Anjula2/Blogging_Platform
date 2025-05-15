@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-6 text-center">
            {{ session('success') }}
        </div>
    @endif

    <x-slot name="header">
        <h2 class="text-3xl font-bold text-center">{{ $post->title }}</h2>
        <p class="text-center text-gray-500">
            By {{ $post->user->name }} | {{ $post->created_at->format('M d, Y') }}
        </p>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 py-8">

        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg mb-6">
        @endif

        <article class="prose max-w-full mx-auto mb-8">
            {!! nl2br(e($post->content)) !!}
        </article>

        {{-- Like and Bookmark Buttons --}}
        @auth
            <div class="flex items-center space-x-6 mb-8">

                <form method="POST" action="{{ route('blog.like', $post->slug) }}">
                    @csrf
                    <button type="submit" class="text-lg px-4 py-2 rounded 
                        {{ 'bg-gray-200 text-gray-800' }}">
                        {{ 'Like' }} ({{ $post->likes->count() }})
                    </button>
                </form>

                <form method="POST" action="{{ route('blog.bookmark', $post->slug) }}">
                    @csrf
                    <button type="submit" class="text-lg px-4 py-2 rounded
                        {{'bg-gray-200 text-gray-800' }}">
                        {{'Save for Later' }}
                    </button>
                </form>

            </div>
        @else
            <p class="mb-8 text-center text-gray-500">Please <a href="{{ route('login') }}" class="text-indigo-600 underline">login</a> to like or save posts.</p>
        @endauth

        {{-- Comments Section --}}
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Comments ({{ $post->comments->count() }})</h3>

            @auth
                <form action="{{ route('blog.comment', $post->slug) }}" method="POST" class="mb-6">
                    @csrf
                    <textarea name="comment" rows="3" class="w-full border rounded p-2" placeholder="Write your comment here..." required></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded">Post Comment</button>
                </form>
            @else
                <p class="mb-4 text-gray-600">Please <a href="{{ route('login') }}" class="text-indigo-600 underline">login</a> to post a comment.</p>
            @endauth

            @forelse ($post->comments as $comment)
                <div class="border-b py-4">
                    <p class="text-gray-700">{{ $comment->comment }}</p>
                    <div class="text-sm text-gray-500 mt-1">
                        By {{ $comment->user->name }} on {{ $comment->created_at->format('M d, Y H:i') }}
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No comments yet.</p>
            @endforelse
        </div>
        <div>
            <a href="{{ route('blog.index') }}" class="text-indigo-600 hover:underline">&larr; Back to all posts</a>
        </div>
    </div>

@endsection
