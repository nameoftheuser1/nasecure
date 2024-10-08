<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <h1 class="text-xl font-bold mb-4">Add Program</h1>
        <form action="{{ route('programs.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="program_name" class="block text-sm font-medium text-gray-700">Program Name</label>
                <input type="text" id="program_name" name="program_name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('program_name') }}" autofocus>
                @error('program_name')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shasdow-sm text-base font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add Program
                </button>
            </div>
        </form>
    </div>
</x-layout>
