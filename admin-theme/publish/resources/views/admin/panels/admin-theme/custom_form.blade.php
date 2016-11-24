@extends( $masterView )

@section('content')

    <div class="panel-heading">
        <h1>{{ core()->h1($h1) }}</h1>
    </div>
    <div class="panel-body">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        {!! Form::open(['url' => Request::url(), 'class' => 'form-horizontal']) !!}
                        @include('admin.panels.admin-theme.form._form')
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        {!! Form::submit($data['btnText'], ['class' => 'btn btn-primary']) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {!! Form::close() !!}
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
