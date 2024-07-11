<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <div class="flex justify-between h-16">
            <h1 class="text-xl font-bold ">Users</h1>
            <div></div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-200 rounded-2xl border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">First Name</th>
                        <th class="py-2 px-4 border-b">Last Name</th>
                        <th class="py-2 px-4 border-b">Contact</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Role</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-blue-50">
                            <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->first_name }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->last_name }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->contact }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->role ? $user->role->name : 'No Role' }}</td>
                            <td class="py-2 px-4 border-b flex justify-center">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded w-full">
                                    Edit
                                </button>
                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded w-full">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-layout>
