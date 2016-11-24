@extends( $masterView )

@section('content')

    <div class="panel-body">
        <div class="box">
            <div class="box-header with-border">
                <h1 class="box-title">{{ core()->h1($h1) }}</h1>
            </div>
            <div class="box-body">
                <p>{!! $data['message'] !!}</p>
            </div>
        </div>
    </div>

@endsection