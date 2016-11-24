<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', core()->title($title) )</title>
    <meta name="description" content="@yield('metaDescription', core()->metaDescription($metaDescription) )">

    @include('core.includes._javascript_variables')
    <meta name="_token" content="{{ csrf_token() }}"/>

    @yield('meta')

    @yield('before-styles-end')
    {!! Html::style(elixir('front-theme/css/front.css')) !!}
    @yield('after-styles-end')

    {!! Html::style('front-theme/css/vendor/google/fonts.css') !!}
    @yield('after-head-js')

</head>
<body id="app-layout">

@include('front.layout._header')
@include('front.layout._content')
@include('front.layout._footer')

<!-- JavaScripts -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>--}}
{{--<script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery/jquery-2.1.4.min.js')}}"><\/script>')</script>--}}
{!! Html::script('front-theme/js/vendor/jquery/jquery-2.1.4.min.js') !!}

{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>--}}
{!! Html::script('front-theme/js/vendor/bootstrap/bootstrap.min.js') !!}

@yield('before-scripts-end')
{!! Html::script(elixir('front-theme/js/front.js')) !!}
@yield('after-scripts-end')

@include('core.includes._ga')

<script>
    $('#flash-overlay-modal').modal();
</script>
<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>

@include('core.includes._ga')

</body>
</html>