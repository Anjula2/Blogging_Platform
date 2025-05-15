@extends('layouts.app')

@section('content')
<div class="relative bg-cover bg-center min-h-screen" style="background-image: url('/images/bg-img.jpg');">
    <div class="bg-black bg-opacity-60 min-h-screen flex items-center justify-center">
        <div class="text-center space-y-6">
            <h1 class="text-4xl font-bold text-white">Welcome, Admin</h1>
            <p class="text-lg text-gray-200">Manage your users and blog posts efficiently</p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admin.users') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md">
                    Manage Users
                </a>
                <a href="{{ route('blog.create') }}"
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md">
                    Create New Post
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
