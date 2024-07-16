<x-layout>
    <x-sidebar />

    @auth
        Hello, you are logged in as {{ Auth::user()->first_name }}

        <x-calendar :dates="$dates" />

    @endauth

    @guest
        You are not logged in.
    @endguest

</x-layout>
