@includephp('admin/panels/admin-theme/form/_form_inputs_foreach_variables.php')
@if($type == 'text')
    <div class="form-group">
        {!! Form::label($name, $name . '-- keyName', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text($name, $value, ['class' => 'form-control', $disabled]) !!}
        </div>
    </div>
@endif

@if($type == 'textarea')
    <div class="form-group">
        {!! Form::label($name, $name . '-- keyName', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::textarea($name, $value, ['class' => 'form-control', $disabled]) !!}
        </div>
    </div>
@endif

@if($type == 'date')
    <div class="form-group">
        {!! Form::label($name, $name . '-- keyName', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::input('date', $name, $value, ['class' => 'form-control', $disabled]) !!}
        </div>
    </div>
@endif

@if($type == 'select')
    <div class="form-group">
        {!! Form::label($name, $name . '-- keyName', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!!  Form::select($name, $options,
            $value, ['class' => 'form-control', $disabled] )  !!}
        </div>
    </div>
@endif