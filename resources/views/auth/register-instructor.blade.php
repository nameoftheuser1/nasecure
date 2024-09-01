<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        border-top: 50px solid blue;
        border-bottom: 50px solid blue;
    }
</style>
<x-layout>
    <div class="flex bg-gray-100 rounded-lg overflow-hidden w-[1000px] -mt-1">
        <div class="flex-1 bg-cover bg-center rounded-l-lg"
            style="background-image: url('{{ asset('images/NASECURE.png') }}');"></div>
        <div class="p-2.5 w-11/12 max-w-sm">
            <div class="text-center mb-3">
                <p class="text-[24px] font-semibold">Register as Instructor</p>
                <a href="{{ route('registerstudent') }}" class="text-sm">You are not an instructor? <span
                        class="underline text-blue-500">Click here</span></a>
            </div>
            <form action="{{ route('registerinstructor') }}" method="post">
                @csrf
                <label class="block text-center mb-2 font-bold" for="last_name">Last Name:</label>
                <input class="w-full p-1 mb-1 border border-gray-300 rounded-md" type="text"
                    placeholder="Enter Last Name" name="last_name" value="{{ old('last_name') }}">
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label class="block text-center mb-2 font-bold" for="first_name">First Name:</label>
                <input class="w-full p-1 mb-1 border border-gray-300 rounded-md" type="text"
                    placeholder="Enter First Name" id="first_name" name="first_name" value="{{ old('first_name') }}">
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label class="block text-center mb-2 font-bold" for="email">Email: (@my.cspc.edu.ph)</label>
                <input class="w-full p-1 mb-1 border border-gray-300 rounded-md" type="text"
                    placeholder="Enter Email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label class="block text-center mb-2 font-bold" for="contact">Contact Number:</label>
                <input class="w-full p-1 mb-1 border border-gray-300 rounded-md" type="text"
                    placeholder="Enter Contact " id="contact" name="contact" value="{{ old('contact') }}">
                @error('contact')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label class="block text-center mb-2 font-bold" for="password">Password:</label>
                <input class="w-full p-1 mb-1 border border-gray-300 rounded-md" type="password"
                    placeholder="Enter Password" id="password" name="password">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label class="block text-center mb-2 font-bold" for="password_confirmation">Confirm Password:</label>
                <input class="w-full p-1 mb-1 border border-gray-300 rounded-md" type="password"
                    placeholder="Enter Password" id="password_confirmation" name="password_confirmation">

                <div class="text-center mb-3 mt-2">
                    <input type="checkbox" id="confirm_instructor" name="confirm_instructor" required>
                    <label for="confirm_instructor" class="font-bold">I confirm that I am an instructor</label>
                </div>

                <button type="submit"
                    class="w-full p-1.5 border-none rounded-md bg-gray-300 cursor-pointer mb-1 hover:bg-blue-700 transition-colors duration-300">Register</button>
                <a href="{{ route('login') }}"
                    class="text-center no-underline block text-sm mt-2.5 hover:underline">Already have an account? <span
                        class="text-blue-700">Login here.</span> </a>
            </form>
        </div>
    </div>
</x-layout>
