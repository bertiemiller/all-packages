@extends($masterView)

@section('metaDescription', 'Resend Email Confirmation')
@section('title', 'Resend Email Confirmation')
@section('h1', 'Resend Email Confirmation')

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">

                {{--<div class="panel-heading">Resend Email Confirmation</div>--}}

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! Form::open(['url' => route('auth.register.confirm.resendEmail'), 'class' => 'form-horizontal']) !!}

                    <div class="form-group">
                        {!! Form::label('email', 'Email Address', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::input('email', 'email', isset($email) ? $email : null,
                            ['class' => 'form-control', 'placeholder' => 'Email Address']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit('Send Email Confirmation Link', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>

    </div>
@endsection
