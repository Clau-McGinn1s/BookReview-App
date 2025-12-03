<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <title>Book Reviews</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
      
    <body class='container mx-auto bg-gray-100  min-h-screen max-w-4xl'>
        <h1 class='text-xs text-gray-400 py-1 pl-5'>Book Review App by Clau McGinnis using Laravel 12</h1>
        <div class='bg-white space-y-2 px-3 mx-3 py-3 rounded-2xl'>
            @yield('content')
        </div>
    </body>
</html>