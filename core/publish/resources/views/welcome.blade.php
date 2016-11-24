@extends('core.layout.master')

@section('title', 'Topic Mine Home')

@section('content')

<h1>Welcome to Topic Mine!</h1>

<div class="panel-body">
    <div class="box">
        <div class="box-body">
            {{ sitemap_list(getSitemap()) }}
        </div>
    </div>
</div>

@endsection
