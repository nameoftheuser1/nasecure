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
            <h1 class="text-xl font-bold ps-4 mb-4">Instructor logs</h1>
        </div>

        <div class="w-full mt-6">
            <form method="GET" action="{{ route('schedules.index') }}" class="flex items-center">
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
                        @if (Auth::user()->role->name === 'admin')
                            <th class="py-2 px-4 border-b">Name</th>
                        @endif
                        <th class="py-2 px-4 border-b">Day</th>
                        <th class="py-2 px-4 border-b">Time In</th>
                        <th class="py-2 px-4 border-b">Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr class="hover:bg-blue-50">
                            @if (Auth::user()->role->name === 'admin')
                                <td class="py-2 px-7 border-b text-center">
                                    {{ $schedule->user->first_name }} {{ $schedule->user->last_name }}
                                </td>
                            @endif
                            <td class="py-2 px-7 border-b text-center">{{ $schedule->day }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $schedule->time_in->format('g:i A') }}</td>
                            <td class="py-2 px-7 border-b text-center">{{ $schedule->time_out->format('g:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-paginator :paginator="$schedules" />
    </div>
</x-layout>
