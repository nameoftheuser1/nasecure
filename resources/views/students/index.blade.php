<x-layout>
    <x-sidebar />
    <div>
        @if (session('success'))
            <x-flashMsg msg="{{ session('success') }}" bg="bg-yellow-500" />
        @elseif(session('deleted'))
            <x-flashMsg msg="{{ session(deleted) }}" bg="bg-red-500" />
        @endif
    </div>
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <div class=" items-center mb-3">
            <h1 class="text-xl font-bold ps-4 mb-4">Students</h1>
            <p class="text-sm ps-8"> Cannot add a student without course added. Must add courses first click here</p>
        </div>
        <div class="flex justify-end">
            <form method="GET" action="{{ route('students.index') }}" class="flex">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit"
                    class="ml-2 px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Search
                </button>
            </form>
            <a href="{{ route('students.create') }}"
                class="ml-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-6 w-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                Add Student
            </a>

        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-200 rounded-2xl border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Student ID</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">RFID</th>
                        <th class="py-2 px-4 border-b">Course ID</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="hover:bg-blue-50">
                            <td class="py-2 px-4 border-b">{{ $student->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $student->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $student->student_id }}</td>
                            <td class="py-2 px-4 border-b">{{ $student->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $student->rfid }}</td>
                            <td class="py-2 px-4 border-b">{{ $student->course_id }}</td>
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
            {{ $students->links() }}
        </div>
    </div>
</x-layout>
