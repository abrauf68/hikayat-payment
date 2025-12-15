<!doctype html>

<html lang="en">

<head>
    <title>{{ \App\Helpers\Helper::getCompanyName() }} - @yield('title')</title>
    @include('layouts.meta')
    @yield('css')
</head>

<body>
    @yield('content')

    @yield('script')
</body>

</html>
