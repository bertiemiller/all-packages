<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<meta name="_csrf_token" content="{{ csrf_token() }}">
<meta name="_api_token" content="{{ session('jwt.token') }}">
<meta name="_core_api_domain" content="{{ config('core.api_domains.core') }}">
<meta name="_sources_api_domain" content="{{ config('core.api_domains.sources') }}">

<meta name="_domain" content="{{ config('app.url') }}">
<meta name="_controller_path" content="{{ core()->controller() }}">
<meta name="_repo_path" content="{{ core()->getRepoPath() }}">
<meta name="_route_name" content="{{ request()->route()->getName() }}">
<meta name="_index_route_name" content="{{ Route::has(core()->routeIndexName()) ? core()->routeIndexName() : null }}">

<title>@yield('title', core()->title($title) )</title>
<meta name="description" content="@yield('meta_description', core()->metaDescription($metaDescription) )">

@yield('meta')
