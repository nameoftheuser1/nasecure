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
                <a href="{{ route('dashboard.index') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Go to Instructor Dashboard
                </a>
            @else
                <p class="text-red-500 font-semibold">Your role does not have a specific redirect link. Please contact
                    the administrator.</p>
            @endif
        </div>
    </div>
</x-layout>
