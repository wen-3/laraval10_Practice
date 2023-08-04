<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>articles</title>
</head>

<body>
    <main>
        @if (session()->has('notice'))
            <div class="bg-pink-300 px-3 py-2 rounded">
                {{ session()->get('notice') }}
            </div>
        @endif

        @yield('main')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>

    @yield('bottom_js')

</body>

</html>
