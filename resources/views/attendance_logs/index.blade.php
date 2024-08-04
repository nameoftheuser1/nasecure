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
            <h1 class="text-xl font-bold ps-4 mb-4">Attendance Logs</h1>
            <p class="text-sm ps-8">View and manage attendance logs here.</p>
        </div>
        <div class="w-full mt-6">
            <form method="GET" action="{{ route('attendance_logs.index') }}" class="flex items-center">
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
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Student Name</th>
                        <th class="py-2 px-4 border-b">Attendance Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendanceLogs as $log)
                        <tr class="hover:bg-blue-50">
                            <td class="py-2 px-7 border-b text-center">{{ $log->id }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $log->student->name }}</td>
                            <td class="py-2 px-7 border-b text-center">
                                {{ \Carbon\Carbon::parse($log->attendance_date)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $attendanceLogs->links() }}
        </div>
    </div>
</x-layout>
