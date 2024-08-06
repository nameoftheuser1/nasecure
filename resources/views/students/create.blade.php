<x-layout>
    <x-sidebar />
    @if (session('error'))
        <x-flashMsg msg="{{ session('error') }}" bg="bg-red-500" />
    @endif

    @if (session('success'))
        <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500" />
    @endif

    @if (session('deleted'))
        <x-flashMsg msg="{{ session('deleted') }}" bg="bg-red-500" />
    @endif
    <div class="container mx-auto w-full p-5 bg-gray-200 rounded-3xl flex">

        <div class="w-full m-5">
            <h1 class="text-xl font-bold mb-4">Add Student</h1>
            <form action="{{ route('students.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <p class="text-red-700 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                    <input type="text" id="student_id" name="student_id"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('student_id') }}" required>
                    @error('student_id')
                        <p class="text-red-700 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" id="email" name="email"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-red-700 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="rfid" class="block text-sm font-medium text-gray-700">RFID</label>
                    <div class="relative">
                        <input type="text" id="rfid" name="rfid"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            value="{{ old('rfid') }}">
                        <span id="rfid_count" class="absolute right-2 bottom-2 text-sm text-gray-500"></span>
                    </div>
                    @error('rfid')
                        <p class="text-red-700 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
                    <select id="section_id" name="section_id"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->section_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Student
                    </button>
                </div>
            </form>
        </div>

        <div class="container mx-auto p-5 bg-gray-200 rounded-3xl w-full">
            <h1 class="text-xl font-bold mb-4">Import Students</h1>
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700">Upload Excel File</label>
                    <input type="file" name="file" id="file" class="mt-1 block w-full">
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 w-full">
                        Import
                    </button>
                </div>
            </form>
        </div>

    </div>
    <script src="{{ asset('js/characterCount.js') }}" defer></script>
</x-layout>
