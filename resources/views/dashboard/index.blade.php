<x-layout>
    <x-sidebar />
    <main class="ps-96">
        @auth
            Hello you are logged in,


            <x-calendar :dates="$dates" />

            <!-- Navigation links -->
            <div class="flex justify-between px-10 py-4">
                <a href="?month={{ $currentMonth->copy()->subMonth()->format('Y-m-d') }}"
                    class="text-blue-500 hover:text-blue-700">Previous Month</a>
                <a href="?month={{ $currentMonth->copy()->addMonths(1)->format('Y-m-d') }}"
                    class="text-blue-500 hover:text-blue-700">Next Month</a>
            </div>
        @endauth

        @guest
            you are not login
        @endguest
    </main>

</x-layout>
