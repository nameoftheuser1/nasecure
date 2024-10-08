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

    </div>

    <div class="flex bg-gray-100 rounded-lg overflow-hidden w-[800px]">
        <div class="flex-1 bg-cover bg-center" style="background-image: url('{{ asset('images/NASECURE.png') }}');">
        </div>
        <div class="flex-1 p-5">
            @if (session('success'))
                <x-flashMsg msg="{{ session('success') }}" bg="bg-yellow-500" />
            @elseif(session('error'))
                <x-flashMsg msg="{{ session('error') }}" bg="bg-red-500" />
            @endif
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
                <a href="{{ route('registerstudent') }}"
                    class="text-center no-underline block text-sm mt-2.5 hover:underline mb-5">Don't have an account?
                    <span class="text-blue-700">Register here.</span></a>
                <a href="{{ route('attendance') }}"
                    class="text-center no-underline block text-sm mt-2.5 hover:underline text-blue-500">
                    Click here for attendance manual.
                </a>
            </form>
        </div>
    </div>
</x-layout>
