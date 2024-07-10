<x-layout>
    <x-sidebar/>
    <main class="ps-96">
        @auth
            Hello you are logged in,
        @endauth

        @guest
            you are not login
        @endguest
    </main>

</x-layout>
