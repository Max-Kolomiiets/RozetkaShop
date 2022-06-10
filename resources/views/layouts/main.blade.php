<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Укрмаркет</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('icons/favicon.ico') }}">

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    
    <link rel="stylesheet" href="{{ asset('css/rozetka-styles.css') }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css')}}">
    <link rel="stylesheet" href="{{ asset('css/icons.css')}}">
    <link rel="stylesheet" href="{{ asset('css/header-styles.css')}}">
    <link rel="stylesheet" href="{{ asset('css/home-styles.css')}}">
    <link rel="stylesheet" href="{{ asset('css/filtres-styles.css')}}">
    <link rel="stylesheet" href="{{ asset('css/product-styles.css')}}">
    <link rel="stylesheet" href="{{ asset('css/cart-styles.css')}}">
    <link rel="stylesheet" href="{{ asset('css/cabinet-styles.css')}}">
</head>

<body>
    <header>
        @include('layouts.header')
    </header>
    <main>
        @yield('main_content')
    </main>
    <!-- Footer -->
    <footer class="page-footer font-small indigo">
        @include('layouts.footer')
    </footer>
    <!-- Footer -->
    
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/cabinet.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script>
        $(function() {
            if (pageScript != null) {
                pageScript()
            }
        })
    </script>
</body>

</html>
