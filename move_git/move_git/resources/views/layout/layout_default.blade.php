<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/vendor.css?hash=' . $hash ) }}" rel="stylesheet">
    <link href="{{ asset('css/application.css?hash=' . $hash ) }}" rel="stylesheet">
    <title>{{$pageTitle}}</title>
</head>
<body class="bg-teal">
@if (Auth::check())
    <input name="application_existing" type="hidden" value="{!! Auth::User()->id !!}"/>

@else
    {!! print_r("User is not login.") !!}
@endif
<header id="header-page">
    <div class="container">
        <div>
            <@include('auth.nav')
            <div class="float-right">
                @if (Auth::check())
                    <a class="nav-link text-light" href="/auth/logout">Hello, {!! Auth::User()->name !!}</a>
                @endif
            </div>
        </div>
    </div>
</header>

<div id="control-bar">
    <div class="container">
        @section('control-section')
            <div class="float-left">
                <ul id="breadcrumb" class="row ">
                    <li class="home"><a title="RockEdu" class="text-light" href="/">RockEdu</a></li>
                    <li class=""><a title="Free test" class="text-light" href="/post">Post</a></li>
                    <li class="active"><a class="text-light">Kiểm tra tiếng Anh theo chuẩn CEFR</a></li>
                </ul>
            </div>
        @show
    </div>
</div>
<div id="header-clean">&nbsp;</div>
<div class="container">
    @yield('container')
</div>
<script>
    var currentUser = {!! json_encode($currentUser) !!};
    var currentUserNavigationControl = {!! json_encode($currentUserNavigationControl) !!};
</script>
<script type="text/javascript" src="{{ asset('js/vendor.min.js?hash='. $hash)  }}"></script>
<script type="text/javascript" src="{{ asset('js/library.min.js?hash='. $hash)  }}"></script>


@yield('script')

<footer>
    The English Company Limited 2018
</footer>
</body>
</html>
