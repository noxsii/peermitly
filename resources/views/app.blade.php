<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.ts'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=akshar:300,400,500,700" rel="stylesheet" />

    @routes
    <x-inertia::head />
</head>
<body>
<x-inertia::app />
</body>
</html>
