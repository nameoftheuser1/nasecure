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
            <h1 class="text-xl font-bold ps-4 mb-4">Courses</h1>
            <p class="text-sm ps-8">Manage your courses here. Add, edit, or delete courses as needed.</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('courses.create') }}"
                class="ml-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-600 flex items-center focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                </svg>
                Add Course
            </a>
        </div>
        <div class="w-full mt-6">
            <form method="GET" action="{{ route('courses.index') }}" class="flex items-center">
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
                        <th class="py-2 px-4 text-center border-b">Course ID</th>
                        <th class="py-2 px-4 text-center border-b">Program Code</th>
                        <th class="py-2 px-4 text-center border-b">Course Name</th>
                        <th class="py-2 px-4 text-center border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr class="hover:bg-blue-50">
                            <td class="py-2 px-4 text-center border-b">{{ $course->id }}</td>
                            <td class="py-2 px-4 text-center border-b">
                                {{ $course->program_code ?? 'Not Set' }}
                            </td>
                            <td class="py-2 px-4 text-center border-b">{{ $course->course_name }}</td>
                            <td class="py-2 px-4 text-center border-b flex justify-center">
                                <a href="{{ route('courses.edit', $course->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded"
                                        onclick="return confirm('Are you sure you want to delete this course?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($courses->hasPages())
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
