@extends($masterView)

@section('title', 'Enter Details')

@section('content')

    <div class="panel-heading h1-panel">
        <h1>Add Urls</h1>
    </div>
    <div class="panel-body">
        <div class="box">
            <div class="box-body">
                <div class="form-horizontal">

                    {!! Form::open(['url' => core()->routeStore(), '_method' => 'POST']) !!}

                    @for($i=1;$i<=10;$i++)
                        <div class="form-group">
                            {!! Form::label('url['.$i.']', 'item '.$i, ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('url['.$i.']', null, ['class' => 'form-control', 'placeholder' => 'Enter url...']) !!}
                            </div>
                        </div>
                    @endfor

                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            {!! Form::submit('Save') !!}
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection
