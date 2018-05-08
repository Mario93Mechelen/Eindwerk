<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Semestr</title>
    <link rel="stylesheet" href="/fonts/fontawesome-free-5.0.12/web-fonts-with-css/css/fontawesome-all.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>

@include('partials.header')

<main>
    @yield('content')
</main>

<footer>

</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@yield('scripts')

</body>
</html>