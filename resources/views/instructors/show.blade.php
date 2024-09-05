<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-100 rounded-3xl flex flex-col items-center">
        <div class="w-full max-w-2xl">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Instructor Details</h1>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-4">
                <div class="space-y-4">
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Name</p>
                        <p class="text-lg font-medium text-gray-800">{{ $instructor->first_name }}
                            {{ $instructor->last_name }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Email</p>
                        <p class="text-lg font-medium text-gray-800 break-all">{{ $instructor->email }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Role</p>
                        <p class="text-lg font-medium text-gray-800">{{ ucfirst($instructor->role->name) }}</p>
                    </div>
                </div>
                <div class="p-4 rounded-lg border border-gray-200 mb-4">
                    <p class="text-sm text-gray-600 font-semibold">Schedules</p>
                    @forelse ($instructor->schedules as $schedule)
                        <div class="p-4 rounded-lg border border-gray-200 mb-2">
                            <p class="text-lg font-medium text-gray-800">{{ ucfirst($schedule->day) }}</p>
                            <p class="text-sm text-gray-600">Time In: {{ $schedule->time_in->format('g:i A') }}</p>
                            <p class="text-sm text-gray-600">Time Out: {{ $schedule->time_out->format('g:i A') }}</p>
                        </div>
                    @empty
                        <p class="text-lg font-medium text-gray-800">No schedules available.</p>
                    @endforelse
                </div>

                <div class="space-y-4">
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Sections</p>
                        @forelse ($instructor->sections as $section)
                            <div class="p-4 rounded-lg border border-gray-200 mb-2">
                                <p class="text-lg font-medium text-gray-800">{{ $section->section_name }}</p>
                                <p class="text-sm text-gray-600">Time In: {{ $section->time_in->format('H:i:s') }}</p>
                                <p class="text-sm text-gray-600">Time Out: {{ $section->time_out->format('H:i:s') }}</p>
                            </div>
                        @empty
                            <p class="text-lg font-medium text-gray-800">No sections assigned.</p>
                        @endforelse
                    </div>
                </div>
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
