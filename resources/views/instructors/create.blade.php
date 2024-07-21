<x-layout>
    <x-sidebar />
    <div class="container mx-auto w-full p-5 bg-gray-200 rounded-3xl flex">

        <div class="w-full m-5">
            <h1 class="text-xl font-bold mb-4">Add Instructor</h1>
            <form action="{{ route('instructors.store') }}" method="POST" class="space-y-4">
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
                    <label for="pin_code" class="block text-sm font-medium text-gray-700">Pin Code</label>
                    <input type="text" id="pin_code" name="pin_code"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('pin_code') }}" required>
                    @error('pin_code')
                        <p class="text-red-700 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="rfid" class="block text-sm font-medium text-gray-700">RFID</label>
                    <input type="text" id="rfid" name="rfid"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('rfid') }}">
                    @error('rfid')
                        <p class="text-red-700 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Instructor
                    </button>
                </div>
            </form>
        </div>

        <div class="container mx-auto p-5 bg-gray-200 rounded-3xl w-full">
            <h1 class="text-xl font-bold mb-4">Import Instructors</h1>
            <form action="{{ route('instructors.import') }}" method="POST" enctype="multipart/form-data">
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
</x-layout>
