<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    @guest
        {{ $slot }}
    @endguest
    <div class="py-5">
    </div>

    @auth
        <div
            class="{{ request()->is('borrowed-kits/borrow') || request()->is('borrowed-kits/return') || request()->is('attendance_logs.pdf ') ? 'pe-10' : 'ps-80 pe-10' }}">
            <main>
                {{ $slot }}
            </main>
        </div>
    @endauth

</body>

</html>
