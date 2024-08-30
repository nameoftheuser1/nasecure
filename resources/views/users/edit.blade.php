<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <h1 class="text-xl font-bold mb-4">Edit User</h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" id="first_name" name="first_name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('first_name', $user->first_name) }}" required autofocus>
                @error('first_name')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" id="last_name" name="last_name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('last_name', $user->last_name) }}" required>
                @error('last_name')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                <input type="text" id="contact" name="contact"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('contact', $user->contact) }}" required>
                @error('contact')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="pin_code" class="block text-sm font-medium text-gray-700">PIN Code</label>
                <input type="text" id="pin_code" name="pin_code"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('pin_code', $user->pin_code) }}">
                @error('pin_code')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rfid" class="block text-sm font-medium text-gray-700">RFID</label>
                <div class="relative">
                    <input type="text" id="rfid" name="rfid"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('rfid', $user->rfid) }}">
                    <span id="rfid_count" class="absolute right-2 bottom-2 text-sm text-gray-500"></span>
                </div>
                @error('rfid')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role_id" name="role_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @if ($role->id == $user->role_id) selected @endif>
                            {{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-red-700 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update User
                </button>
            </div>
        </form>
        @if (!$user->verified_at)
            <form action="{{ route('users.verify', $user->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Verify User
                </button>
            </form>
        @endif
    </div>
    <script src="{{ asset('js/characterCount.js') }}" defer></script>
</x-layout>
