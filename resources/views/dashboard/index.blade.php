<x-layout>
    <x-sidebar />
    <main class="ps-96">
        @auth
            Hello, you are logged in,

            <x-calendar :dates="$dates" />

        @endauth

        @guest
            You are not logged in.
        @endguest
    </main>

</x-layout>
