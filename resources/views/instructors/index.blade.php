<x-layout>
    <x-sidebar />
    <div>
        @if (session('error'))
            <x-flashMsg msg="{{ session('error') }}" bg="bg-red-500" />
        @endif
    </div>

    <div class="container mx-auto p-5 bg-gray-200 rounded-3xl">
        <div class="items-center mb-3">
            <h1 class="text-xl font-bold ps-4 mb-4">Instructors</h1>
        </div>

        <div class="w-full mb-6">
            <form method="GET" action="{{ route('instructors.index') }}" class="flex items-center">
                <div class="relative flex w-full">
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full">
                    <button type="submit"
                        class="absolute right-0 top-0 h-full px-4 bg-blue-700 text-white rounded-r-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($instructors as $instructor)
                @php
                    $imgUrl = $instructor->img_url;
                    $defaultImage = 'images/profile.png';
                    $imageSource = $imgUrl === $defaultImage ? asset($defaultImage) : asset('storage/' . $imgUrl);
                @endphp
                <a href="{{ route('instructors.show', $instructor->id) }}"
                    class="bg-white p-4 rounded-lg shadow-lg hover:bg-blue-700 hover:text-white hover:shadow-xl transition-all duration-300 ease-in-out cursor-pointer">
                    <img src="{{ $imageSource }}" alt="Profile Picture" class="w-40 h-40 rounded-full mx-auto mb-4">
                    <h2 class="text-xl font-semibold mb-2 text-center">
                        {{ $instructor->first_name ?? 'Not Set' }} {{ $instructor->last_name ?? '' }}
                    </h2>
                    <p class="text-sm">{{ $instructor->email }}</p>
                </a>
            @endforeach
        </div>

        <x-paginator :paginator="$instructors" />
    </div>
</x-layout>
