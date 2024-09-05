<x-layout>
    <div class="flex flex-col items-center justify-center">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h1 class="text-2xl font-bold mb-4">Unauthorized Access</h1>
            <p class="mb-4">If you are here because you accessed a webpage that is unauthorized for your role, please
                use the appropriate link below:</p>

            @if (Auth()->user()->role->name === 'student')
                <a href="{{ route('studentprofile') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Go to Student Profile
                </a>
            @elseif (Auth()->user()->role->name === 'instructor')
                <p class="mb-10 text-white p-2 border-red-500 bg-red-500 rounded-lg ">Maybe you registered as an instructor, but your account has not been verified. Please
                    contact the admin to verify your account.</p>
                <a href="{{ route('students.index') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded text-center">
                    Go to Student list
                </a>
            @else
                <p class="text-red-500 font-semibold">Your role does not have a specific redirect link. Please contact
                    the administrator.</p>
            @endif
        </div>
        <div class="mv-3">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit"
                    class="inline-block bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-layout>
