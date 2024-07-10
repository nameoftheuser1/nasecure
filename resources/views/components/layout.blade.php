<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <div class="py-5">

        @guest
            <div class="container">
                {{ $slot }}
            </div>
        @endguest
    </div>


    @auth
        <div class="ps-96 pe-28">
            <main>
                {{ $slot }}
            </main>
        </div>
    @endauth


</body>

</html>
