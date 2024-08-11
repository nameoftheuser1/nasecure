<x-layout>
    <x-sidebar />
    <div>
        @if (session('success'))
            <x-flashMsg msg="{{ session('success') }}" />
        @elseif(session('deleted'))
            <x-flashMsg msg="{{ session('deleted') }}" bg="bg-red-500" />
        @endif
    </div>
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <div class="items-center mb-3">
            <h1 class="text-xl font-bold ps-4 mb-4">Kits</h1>
            <p class="text-sm ps-8">You can manage the available kits here. Ensure to update the quantity when kits are
                borrowed or returned.</p>
        </div>
        <div class="flex justify-end items-center">
            <a href="{{ route('kits.create') }}"
                class="ml-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-600 flex items-center focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-6 w-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                Add Kit
            </a>
        </div>
        <div class="w-full mt-6">
            <form method="GET" action="{{ route('kits.index') }}" class="flex items-center">
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
                        <th class="py-2 px-4 text-center border-b">Kit ID</th>
                        <th class="py-2 px-4 text-center border-b">Kit Name</th>
                        <th class="py-2 px-4 text-center border-b">Description</th>
                        <th class="py-2 px-4 text-center border-b">Quantity</th>
                        <th class="py-2 px-4 text-center border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kits as $kit)
                        <tr class="hover:bg-blue-50 cursor-pointer"
                            onclick="window.location='{{ route('kits.show', $kit->id) }}';">
                            <td class="py-2 px-4 text-center border-b">{{ $kit->id }}</td>
                            <td class="py-2 px-4 text-center border-b">{{ $kit->kit_name }}</td>
                            <td class="py-2 px-4 text-center border-b">{{ $kit->description }}</td>
                            <td class="py-2 px-4 text-center border-b">{{ $kit->quantity }}</td>
                            <td class="py-2 px-4 text-center border-b flex justify-center gap-2">
                                <a href="{{ route('kits.edit', $kit->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('kits.destroy', $kit->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded"
                                        onclick="return confirm('Are you sure you want to delete this kit?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($kits->hasPages())
            <div class="mt-4">
                <ul class="flex justify-center space-x-2">
                    <li>
                        <a href="{{ $kits->url(1) }}" aria-label="First"
                            class="px-3 py-1 border rounded-md hover:bg-gray-200
                    {{ $kits->onFirstPage() ? 'cursor-not-allowed text-gray-400' : '' }}">
                            << </a>
                    </li>

                    <li>
                        <a href="{{ $kits->previousPageUrl() }}" aria-label="Previous"
                            class="px-3 py-1 border rounded-md hover:bg-gray-200
                    {{ $kits->onFirstPage() ? 'cursor-not-allowed text-gray-400' : '' }}">
                            Previous
                        </a>
                    </li>

                    @for ($page = 1; $page <= $kits->lastPage(); $page++)
                        <li>
                            <a href="{{ $kits->url($page) }}"
                                class="px-3 py-1 border rounded-md hover:bg-gray-200
                        {{ $kits->currentPage() == $page ? 'bg-gray-300 text-gray-700' : '' }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endfor

                    <li>
                        <a href="{{ $kits->nextPageUrl() }}" aria-label="Next"
                            class="px-3 py-1 border rounded-md hover:bg-gray-200
                    {{ $kits->hasMorePages() ? '' : 'cursor-not-allowed text-gray-400' }}">
                            Next
                        </a>
                    </li>

                    <li>
                        <a href="{{ $kits->url($kits->lastPage()) }}" aria-label="Last"
                            class="px-3 py-1 border rounded-md hover:bg-gray-200
                    {{ $kits->hasMorePages() ? '' : 'cursor-not-allowed text-gray-400' }}">
                            >>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</x-layout>
