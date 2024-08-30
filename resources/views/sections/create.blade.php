<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <h1 class="text-xl font-bold mb-4">Add Section</h1>
        <form action="{{ route('sections.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="section_name" class="block text-sm font-medium text-gray-700">Section Name</label>
                <input type="text" id="section_name" name="section_name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('section_name') }}" autofocus>
                @error('section_name')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                <select id="course_id" name="course_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select Course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="time_in" class="block text-sm font-medium text-gray-700">Time In</label>
                <input type="time" id="time_in" name="time_in"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('time_in') }}">
                @error('time_in')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="time_out" class="block text-sm font-medium text-gray-700">Time Out</label>
                <input type="time" id="time_out" name="time_out"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('time_out') }}">
                @error('time_out')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add Section
                </button>
            </div>
        </form>
    </div>
</x-layout>
