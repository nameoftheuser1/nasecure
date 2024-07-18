<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <h1 class="text-xl font-bold mb-4">Edit Course</h1>
        <form action="{{ route('courses.update', $course->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="program_id" class="block text-sm font-medium text-gray-700">Program</label>
                <select id="program_id" name="program_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="" disabled>Select a program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ $course->program_id == $program->id ? 'selected' : '' }}>
                            {{ $program->program_code }} - {{ $program->program_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="course_name" class="block text-sm font-medium text-gray-700">Course Name</label>
                <input type="text" id="course_name" name="course_name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('course_name', $course->course_name) }}" required>
            </div>
            <div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Course
                </button>
            </div>
        </form>
    </div>
</x-layout>
