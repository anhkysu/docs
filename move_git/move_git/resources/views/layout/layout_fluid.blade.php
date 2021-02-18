<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/vendor.css?hash=' . $hash ) }}" rel="stylesheet">
    <link href="{{ asset('css/appsite.css?hash=' . $hash ) }}" rel="stylesheet">
    <title>{{$pageTitle}}</title>
</head>
<body class="bg-teal">

@if (Auth::check())
    <input type="hidden" value="{!! Auth::User()->id !!}"/>

@else
    {!! print_r("User is not login.") !!}
@endif

<header class="container-fluid">
    @include('auth.nav')
</header>

<div id="control-bar" class="pl-4 pr-4">
    {{--<div>--}}
        {{--@section('control-section')--}}
            {{--<div class="float-left">--}}
                {{--<ul id="breadcrumb" class="row ">--}}
                    {{--<li class="home"><a title="RockEdu" class="text-light" href="/">RockEdu</a></li>--}}
                    {{--<li class=""><a title="Free test" class="text-light" href="/post">Post</a></li>--}}
                    {{--<li class="active"><a class="text-light">Kiểm tra tiếng Anh theo chuẩn CEFR</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--@show--}}
    {{--</div>--}}
</div>

<div id="toast-notification" class="toast" role="alert" style="position: absolute; top: 5px; right: 20px; z-index: 1051;">
    <div class="alert alert-success p-1 m-0" role="alert">
        <div class="alert-heading">
            <strong class="type-message mr-auto">Loi</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <hr>
        <div class="alert-body">
        </div>
    </div>
</div>

<div class="container-fluid">
    @yield('container')
</div>
<script>
    var currentUser = {!! json_encode($currentUser) !!};
    var currentUserNavigationControl = {!! json_encode($currentUserNavigationControl) !!};
</script>
<script type="text/javascript" src="{{ asset('js/vendor.min.js?hash='. $hash) }}"></script>
<script type="text/javascript" src="{{ asset('js/library.min.js?hash='. $hash) }}"></script>

@yield('script')

<footer>
    <p class="text-white text-sm-center">POWERED BY R&D ITSC</p>
</footer>
</body>
</html>
