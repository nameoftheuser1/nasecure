<x-layout>
    <x-sidebar />

    @auth

    @endauth

    @guest
        You are not logged in.
    @endguest

</x-layout>
