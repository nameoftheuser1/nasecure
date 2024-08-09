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
            <h1 class="text-xl font-bold ps-4 mb-4">Borrowed Kits</h1>
            <p class="text-sm ps-8">Manage borrowed kits here. Ensure that borrowed kits are tracked properly.</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('borrowed-kits.create') }}"
                class="ml-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-600 flex items-center focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                Add Borrowed Kit
            </a>
        </div>
        <div class="w-full mt-6">
            <form method="GET" action="{{ route('borrowed-kits.index') }}" class="flex items-center">
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
                        <th class="py-2 px-4 border-b">Kit ID</th>
                        <th class="py-2 px-4 border-b">Kit Name</th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <th class="py-2 px-4 border-b">Quantity Borrowed</th>
                        <th class="py-2 px-4 border-b">Student Email</th>
                        <th class="py-2 px-4 border-b">Borrowed At</th>
                        <th class="py-2 px-4 border-b">Due Date</th>
                        <th class="py-2 px-4 border-b">Returned At</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b w-40">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowedKits as $borrowedKit)
                        <tr class="hover:bg-blue-50">
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->kit_id }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->kit->kit_name ?? 'N/A' }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->kit->description ?? 'N/A' }}
                            </td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->quantity_borrowed }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->student->email ?? 'N/A' }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->borrowed_at }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->due_date }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->returned_at }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->status }}</td>
                            <td class="py-2 px-7 border-b flex justify-center w-40">
                                <a href="{{ route('borrowed-kits.edit', $borrowedKit->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('borrowed-kits.destroy', $borrowedKit->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded"
                                        onclick="return confirm('Are you sure you want to delete this borrowed kit?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $borrowedKits->links() }}
        </div>
    </div>
</x-layout>
