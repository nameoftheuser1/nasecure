<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #ffffff;
        border-top: 50px solid blue;
        border-bottom: 50px solid blue;
    }
</style>
<x-layout>
    <div class="fixed right-1/2 top-1/4 ">
        <a href="{{ route('attendance') }}" class="flex mb-5 border-2 rounded-lg p-4 w-52 bg-gray-100 hover:bg-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <span>Attendance Manual</span>
        </a>
    </div>
    <div class="flex bg-gray-100 rounded-lg overflow-hidden w-[800px]">
        <div class="flex-1 bg-cover bg-center" style="background-image: url('{{ asset('images/NASECURE.png') }}');">
        </div>
        <div class="flex-1 p-5">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <label class="block text-center mb-2 font-bold" for="email">Email (@my.cspc.edu.ph)</label>
                <input class="w-full p-1 mb-1 border border-gray-300 rounded-md" type="text"
                    placeholder="Enter Email" value="{{ old('email') }}" id="email" name="email">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
                <label class="block text-center mb-2 font-bold" for="password">Password</label>
                <input class="w-full p-1 mb-1 border border-gray-300 rounded-md" type="password"
                    placeholder="Enter Password" id="password" name="password">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
                <button
                    class="w-full p-1.5 border-none rounded-md bg-gray-300 cursor-pointer mb-1 hover:bg-blue-700 transition-colors duration-300"
                    type="submit">Log In</button>
                <a href="{{ route('resetpasswordguide') }}"
                    class="text-center no-underline block text-sm mt-2.5 hover:underline">Reset
                    Password</a>
                <a href="{{ route('register') }}"
                    class="text-center no-underline block text-sm mt-2.5 hover:underline">Don't have an account? <span
                        class="text-blue-700">Register here.</span></a>
            </form>
        </div>
    </div>
</x-layout>
