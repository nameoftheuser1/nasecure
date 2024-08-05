<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-100 rounded-3xl flex flex-col items-center ">
        <div class="w-full max-w-2xl">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Instructor Details</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Name</p>
                        <p class="text-lg font-medium text-gray-800">{{ $instructor->name }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Pin Code</p>
                        <p class="text-lg font-medium text-gray-800">{{ $instructor->pin_code }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Email</p>
                        <p class="text-lg font-medium text-gray-800 break-all">{{ $instructor->email }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">RFID</p>
                        <p class="text-lg font-medium text-gray-800">{{ $instructor->rfid }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Sections</h2>
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200">Section Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Student Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($instructor->sections as $section)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $section->section_name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $section->student_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200 text-center" colspan="2">No sections
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('instructors.index') }}"
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
