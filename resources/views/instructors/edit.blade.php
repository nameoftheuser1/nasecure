<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <h1 class="text-xl font-bold mb-4">Edit Instructor</h1>
        <form action="{{ route('instructors.update', $instructor->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('name', $instructor->name) }}" required autofocus>
                @error('name')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="pin_code" class="block text-sm font-medium text-gray-700">Pin Code</label>
                <div class="relative">
                    <input type="number" id="pin_code" name="pin_code"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm pr-10"
                        value="{{ old('pin_code', $instructor->pin_code) }}" required>
                    <span id="pin_code_count" class="absolute right-2 top-2 text-sm text-gray-500"></span>
                    @error('pin_code')
                        <p class="text-red-700 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="rfid" class="block text-sm font-medium text-gray-700">RFID</label>
                <div class="relative">
                    <input type="text" id="rfid" name="rfid"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm pr-10"
                        value="{{ old('rfid', $instructor->rfid) }}">
                    <span id="rfid_count" class="absolute right-2 top-2 text-sm text-gray-500"></span>
                    @error('rfid')
                        <p class="text-red-700 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Instructor
                </button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/characterCount.js') }}" defer></script>
</x-layout>
