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
            style="background-image: url('{{ asset('images/NASECURE.png') }}');">
        </div>

        <div class="p-4 w-11/12 max-w-sm flex flex-col justify-center items-center">
            <h1 class="text-3xl font-bold mb-6 text-center">Attendance</h1>

            @if (session('success'))
                <x-flashMsg msg="{{ session('success') }}" bg="bg-yellow-500" />
            @elseif(session('failed'))
                <x-flashMsg msg="{{ session('failed') }}" bg="bg-red-500" />
            @endif

            @error('email')
                <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="mb-6 w-full">
                <h2 class="font-semibold mb-4 text-center">Record Time In</h2>
                <form action="{{ route('attendance.timeIn') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email_in" class="block text-sm font-medium text-gray-700 text-center">Student
                            Email</label>
                        <input type="text" id="email_in" name="email"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                            placeholder="Enter Email" required>

                    </div>
                    <button type="submit"
                        class="w-full p-1.5 border-none rounded-md bg-gray-300 cursor-pointer mb-1 hover:bg-blue-700 transition-colors duration-300">Record
                        Time In</button>
                </form>
            </div>

            <div class="mb-6 w-full">
                <h2 class="font-semibold mb-4 text-center">Record Time Out</h2>
                <form action="{{ route('attendance.timeOut') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email_out" class="block text-sm font-medium text-gray-700 text-center">Student
                            Email</label>
                        <input type="text" id="email_out" name="email"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                            placeholder="Enter Email" required>
                    </div>
                    <button type="submit"
                        class="w-full p-1.5 border-none rounded-md bg-gray-300 cursor-pointer mb-1 hover:bg-blue-700 transition-colors duration-300">Record
                        Time Out</button>
                </form>
                <a href="{{ route('login') }}" class="text-center no-underline block text-sm mt-2.5 hover:underline">Do
                    you want to login? <span class="text-blue-700">Login here.</span> </a>
            </div>
        </div>
    </div>
</x-layout>
