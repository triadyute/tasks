<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tasks App</title>

    <!-- Laravel CSS -->
    <link href="{{asset('/css/app.css')}}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{asset('/css/sticky-footer-navbar.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
</head>

<body class="d-flex flex-column h-100">
    <div id="app">
        <tasks-header></tasks-header>
        <!-- Begin page content -->
        <main role="main" class="flex-shrink-0">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
    <script src="{{asset('/js/app.js')}}"></script>
</body>

</html>
