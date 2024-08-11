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
        <a href="{{ route('borrowed-kits.borrow') }}"
            class="flex mb-5 border-2 rounded-lg p-4 w-full justify-center bg-gray-100 hover:bg-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
            </svg>
            <span>Borrow kits</span>
        </a>
        <div class="w-full mt-6">
            <form method="GET" action="{{ route('borrowed-kits') }}" class="flex items-center">
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
                        <th class="py-2 px-4 border-b">Quantity Borrowed</th>
                        <th class="py-2 px-4 border-b">Student Email</th>
                        <th class="py-2 px-4 border-b">Borrowed At</th>
                        <th class="py-2 px-4 border-b">Due Date</th>
                        <th class="py-2 px-4 border-b">Returned At</th>
                        <th class="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowedKits as $borrowedKit)
                        <tr class="hover:bg-blue-50">
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->kit_id }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->kit->kit_name ?? 'N/A' }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->quantity_borrowed }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->student->email ?? 'N/A' }}</td>
                            <td class="py-2 px-7 border-b text-center">
                                {{ $borrowedKit->borrowed_at ? $borrowedKit->borrowed_at->format('Y-m-d') : '' }}
                            </td>
                            <td class="py-2 px-7 border-b text-center">
                                {{ $borrowedKit->due_date ? $borrowedKit->due_date->format('Y-m-d') : '' }}
                            </td>
                            <td class="py-2 px-7 border-b text-center">
                                {{ $borrowedKit->returned_at ? $borrowedKit->returned_at->format('Y-m-d') : 'not returned yet' }}
                            </td>
                            <td class="py-2 px-7 border-b text-center">{{ $borrowedKit->status }}</td>
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
