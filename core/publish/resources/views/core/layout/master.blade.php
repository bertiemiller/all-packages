<!doctype html>
<html class="no-js" lang="">
<head>

    @include('core.includes._javascript_variables')
    @include('core.layout.includes._meta')
    @include('core.layout.includes._head_css')
    @include('core.layout.includes._head_js')

</head>
<body>

<table id="main">
    <tr>
        <td colspan="2">@include('core.layout._header')</td>
    </tr>
    <tr>
        <td class="leftCol">
            @include('core.layout.sidebar._main_left_nav')
            @include('core.layout._sidebar')
        </td>
        <td>@include('core.layout._content')</td>
    </tr>
    <tr>
        <td colspan="2">@include('core.layout._footer')</td>
    </tr>
</table>

@include('core.layout.includes._end_js')

</body>
</html>