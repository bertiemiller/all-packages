@extends($masterView)

@section('metaDescription', 'Subscribe to Topic Mine')
@section('title', 'Subscribe to Topic Mine')
@section('h1', 'Subscribe to Topic Mine')

@section('after-scripts-end')
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>

        $.validate({
            form : '#registrationForm',
            modules : 'location, date, security, file, html5',
            onModulesLoaded : function() {
                $('input[name="country"]').suggestCountry();
            },
            onElementValidate : function(valid, $el, $form, errorMess) {
                console.log('Input ' +$el.attr('name')+ ' is ' + ( valid ? 'VALID':'NOT VALID') );
            }
        });

        // Validation event listeners
        $('input')
                .on('beforeValidation', function(value, lang, config) {
                    console.log('Input "'+this.name+'" is about to become validated');
                    // Call $(this).attr('data-validation-skipped', 1); to prevent validation
                })
                .on('validation', function(evt, valid) {
                    console.log('Input "'+this.name+'" is ' + (valid ? 'VALID' : 'NOT VALID'));
                });
    </script>
@endsection

@section('content')
    <div class="panel-body">
        {!! Form::open(['url' => 'register-subscription', 'class' => 'form-horizontal', 'id' => 'registrationForm']) !!}
        <div class="form-group">
            <span class="col-md-4 control-label"></span>
            <div class="col-md-6">
                <h3>Login Details</h3>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('email', 'Email Address',
            ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('email', 'email', null,
                [
                'class' => 'form-control',
                'placeholder' => 'Email',
                'data-validation' => 'email',
                ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('password', 'password', null,
                [
                'class' => 'form-control',
                'placeholder' => 'Password',
                'data-validation' => 'strength',
                'data-validation-strength' => '1',
                ]) !!}
                
            </div>

        </div>

        <div class="form-group">
            {!! Form::label('password_confirmation', 'Password Confirmation', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('password', 'password_confirmation', null, [
                'class' => 'form-control',
                'placeholder' => 'Password Confirmation',
                'data-validation' => 'confirmation',
                'data-validation-confirm' => 'password'
                 ]) !!}
            </div>
        </div>
        
        <div class="form-group">
            <span class="col-md-4 control-label"></span>
            <div class="col-md-6">
                <h3>Personal Details</h3>
            </div>
        </div>
        
        <div class="form-group">
            {!! Form::label('first_name', 'First Name', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('first_name', 'first_name', null, [
                'class' => 'form-control', 'placeholder' => 'First Name']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('last_name', 'Last Name', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('last_name', 'last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Job Title</label>
            <div class="col-md-6">
                {!!  Form::select('job_title', $jobTitleOptions, null, ['class' => 'form-control'] )  !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('tel', 'Tel', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('tel', 'tel', null,
                ['class' => 'form-control',
                'placeholder' => 'Tel',
                'data-validation' => 'number'
                ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('date_of_birth', 'Date of Birth', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('date_of_birth', 'date_of_birth', null, [
                'class' => 'form-control',
                'placeholder' => 'dd/mm/yyyy',
                'data-validation' => 'birthdate',
                'data-validation-help' => 'dd/mm/yyyy',
                'data-validation-format' => 'dd/mm/yyyy',
                ]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Register', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

@endsection