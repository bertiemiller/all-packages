<!doctype html>
<html class="no-js" lang="">
<head>

    @include('core.includes._javascript_variables')
    @include('admin.layout.includes._meta')
    @include('admin.layout.includes._head_css')
    @include('admin.layout.includes._head_js')

</head>
<body class="skin-{!! config('admin.theme') !!} hold-transition sidebar-mini">
<div class="wrapper">

    @include('admin.layout._header')
    @include('admin.layout._sidebar')
    @include('admin.layout._content')
    @include('admin.layout._footer')

</div>

@include('admin.layout.includes._end_js')
@include('core.includes._ga')

</body>
</html>