@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-gray-100 mb-8">
        Admin Dashboard - Users
    </h1>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 rounded-md bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-100 dark:bg-gray-800 text-left text-gray-700 dark:text-gray-200 text-sm uppercase">
                <tr>
                    <th class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">ID</th>
                    <th class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">Name</th>
                    <th class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">Email</th>
                    <th class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">Roles</th>
                    <th class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">Assign Role</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 dark:text-gray-300">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $user->id }}</td>
                        <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-indigo-100 dark:bg-indigo-700 text-indigo-800 dark:text-indigo-200 px-2 py-1 rounded text-xs font-semibold">
                                {{ $user->roles->pluck('name')->join(', ') ?: 'None' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2">
                                <form method="POST" action="{{ route('admin.assignRole', $user->id) }}">
                                    @csrf
                                    <input type="hidden" name="role" value="admin">
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1 rounded">
                                        Make Admin
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.assignRole', $user->id) }}">
                                    @csrf
                                    <input type="hidden" name="role" value="editor">
                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold px-3 py-1 rounded">
                                        Make Editor
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.assignRole', $user->id) }}">
                                    @csrf
                                    <input type="hidden" name="role" value="reader">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1 rounded">
                                        Make Reader
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $users->links() }}
    </div>
    <div>
        <a href="{{ route('admin.index') }}" class="text-indigo-600 hover:underline">&larr; Back to Admin Dashboard</a>
    </di>
</div>
@endsection
