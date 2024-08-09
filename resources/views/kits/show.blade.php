<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-100 rounded-3xl flex flex-col items-center ">
        <div class="w-full max-w-2xl">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Kit Details</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Kit Name</p>
                        <p class="text-lg font-medium text-gray-800">{{ $kit->kit_name }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Description</p>
                        <p class="text-lg font-medium text-gray-800">{{ $kit->description }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Quantity</p>
                        <p class="text-lg font-medium text-gray-800">{{ $kit->quantity }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full mt-10">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Borrowed Kits</h2>
                <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="py-3 px-6 text-left">Student Name</th>
                                <th class="py-3 px-6 text-left">Quantity Borrowed</th>
                                <th class="py-3 px-6 text-left">Borrowed At</th>
                                <th class="py-3 px-6 text-left">Due Date</th>
                                <th class="py-3 px-6 text-left">Returned At</th>
                                <th class="py-3 px-6 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse ($borrowedKits as $borrowedKit)
                                @php
                                    $student = $students->firstWhere('id', $borrowedKit->student_id);
                                @endphp
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        {{ $student ? $student->name : 'Unknown' }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $borrowedKit->quantity_borrowed }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ optional($borrowedKit->borrowed_at)->format('Y-m-d H:i:s') ?? '' }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ optional($borrowedKit->due_date)->format('Y-m-d') ?? '' }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ optional($borrowedKit->returned_at)->format('Y-m-d H:i:s') ?? '' }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $borrowedKit->status }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-6 text-center">No borrowed kits found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $borrowedKits->links() }}
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('kits.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-full shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>
</x-layout>
