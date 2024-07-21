<x-layout>
    <a href="{{ route('dashboard.index') }}" class="text-blue-500 hover:text-blue-700 mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Dashboard
    </a>
    <div class="container p-4 w-1/2 ms-60">
        <div class="flex items-center mb-4">

            <div class="flex-1 text-center">
                @if ($user->img_url)
                    <img src="{{ Storage::url($user->img_url) }}" alt="Profile Picture"
                        class="w-40 h-40 rounded-full mx-auto mb-4">
                @else
                    <div
                        class="w-24 h-24 rounded-full bg-gray-200 mx-auto mb-4 flex items-center justify-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 5.121a3 3 0 014.242 0M6.414 6.414a4.5 4.5 0 016.364 0M8.121 8.121a6 6 0 018.485 0M14.828 14.828a6 6 0 00-8.485 0M18.364 18.364a4.5 4.5 0 00-6.364 0M17.879 17.879a3 3 0 00-4.242 0" />
                        </svg>
                    </div>
                @endif

                <h1 class="text-2xl font-bold">Profile Settings</h1>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="flex gap-2">
                <div class="mb-4 w-1/2">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name"
                        value="{{ old('first_name', $user->first_name) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('first_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 w-1/2">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name"
                        value="{{ old('last_name', $user->last_name) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('last_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                <input type="text" name="contact" id="contact" value="{{ old('contact', $user->contact) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('contact')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="img_url" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <input type="file" name="img_url" id="img_url"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2">
                @error('img_url')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <button type="submit" class="bg-blue-500 w-full text-white px-4 py-2 rounded-md hover:bg-blue-600">Update
                Profile</button>
        </form>
    </div>
</x-layout>
