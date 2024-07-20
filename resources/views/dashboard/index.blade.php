<x-layout>
    <x-sidebar />

    @auth

        <x-calendar :dates="$dates" />

    @endauth

    @guest
        You are not logged in.
    @endguest

</x-layout>
