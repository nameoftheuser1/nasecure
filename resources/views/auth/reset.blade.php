<x-layout>
    <div class="w-full flex justify-center items-center min-h-svh">
        <div class="container mx-auto p-5 bg-gray-200 rounded-3xl w-1/4">
            <h1 class="text-xl font-bold mb-4">Reset Your Password</h1>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <button type="submit"
                    class="w-full p-1.5 border-none rounded-md bg-gray-300 cursor-pointer mb-1 hover:bg-blue-700 transition-colors duration-300">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</x-layout>
