<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <h1 class="text-xl font-bold mb-4">Edit Schedule</h1>
        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                <select id="user_id" name="user_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('user_id', $schedule->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
                <select id="day" name="day"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select Day</option>
                    <option value="monday" {{ old('day', strtolower($schedule->day)) == 'monday' ? 'selected' : '' }}>
                        Monday</option>
                    <option value="tuesday" {{ old('day', strtolower($schedule->day)) == 'tuesday' ? 'selected' : '' }}>
                        Tuesday</option>
                    <option value="wednesday"
                        {{ old('day', strtolower($schedule->day)) == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                    <option value="thursday"
                        {{ old('day', strtolower($schedule->day)) == 'thursday' ? 'selected' : '' }}>Thursday</option>
                    <option value="friday" {{ old('day', strtolower($schedule->day)) == 'friday' ? 'selected' : '' }}>
                        Friday</option>
                    <option value="saturday"
                        {{ old('day', strtolower($schedule->day)) == 'saturday' ? 'selected' : '' }}>Saturday</option>
                    <option value="sunday" {{ old('day', strtolower($schedule->day)) == 'sunday' ? 'selected' : '' }}>
                        Sunday</option>
                </select>
                @error('day')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="time_in" class="block text-sm font-medium text-gray-700">Time In</label>
                <input type="time" id="time_in" name="time_in"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('time_in', $schedule->time_in->format('H:i')) }}">
                @error('time_in')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="time_out" class="block text-sm font-medium text-gray-700">Time Out</label>
                <input type="time" id="time_out" name="time_out"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('time_out', $schedule->time_out->format('H:i')) }}">
                @error('time_out')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Schedule
                </button>
            </div>
        </form>
    </div>
</x-layout>
