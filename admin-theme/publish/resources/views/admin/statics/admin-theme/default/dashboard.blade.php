@extends($masterView)

@section('content')

    <div class="panel-heading">
        <h1>{{ core()->h1($h1) }}</h1>
    </div>
    <div class="panel-body">
        <div class="box">
            <div class="box-body">
                {{ $content }}
            </div>
        </div>
    </div>

@endsection