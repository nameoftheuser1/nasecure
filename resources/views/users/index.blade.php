<x-layout>
    <x-sidebar />
    <div>
        @if (session('success'))
            <x-flashMsg msg="{{ session('success') }}" bg="bg-yellow-500" />
        @elseif(session('deleted'))
            <x-flashMsg msg="{{ session('deleted') }}" bg="bg-red-500" />
        @endif
    </div>
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <div class="items-center mb-3">
            <h1 class="text-xl font-bold ps-4 mb-4">Users</h1>
            <p class="text-sm ps-8">The list of registered users here.</p>
        </div>
        <div class="flex justify-end">
        </div>
        <div class="w-full mt-6">
            <form method="GET" action="{{ route('users') }}" class="flex items-center">
                <div class="relative flex w-full">
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full">
                    <button type="submit"
                        class="absolute right-0 top-0 h-full px-4 bg-blue-700 text-white rounded-r-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-200 rounded-2xl border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 text-center border-b">First Name</th>
                        <th class="py-2 px-4 text-center border-b">Last Name</th>
                        <th class="py-2 px-4 text-center border-b">Contact</th>
                        <th class="py-2 px-4 text-center border-b">Email</th>
                        <th class="py-2 px-4 text-center border-b">Role</th>
                        <th class="py-2 px-4 text-center border-b">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-blue-50">
                            <td class="py-2 px-4 text-center border-b">{{ $user->first_name }}</td>
                            <td class="py-2 px-4 text-center border-b">{{ $user->last_name }}</td>
                            <td class="py-2 px-4 text-center border-b">{{ $user->contact }}</td>
                            <td class="py-2 px-4 text-center border-b">{{ $user->email }}</td>
                            <td class="py-2 px-4 text-center border-b">
                                {{ $user->role ? $user->role->name : 'No Role' }}
                            </td>
                            <td class="py-2 px-4 text-center border-b flex justify-center gap-2">
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                    Edit
                                </a>
                            </td>
                            <td class="py-2 px-4 text-center border-b">
                                <form action="{{ route('users.resetPassword', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                        Reset Password
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-paginator :paginator="$users" />
    </div>
</x-layout>
