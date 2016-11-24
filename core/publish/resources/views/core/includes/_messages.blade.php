<!--
<div class="panel panel-primary">...</div>
<div class="panel panel-success">...</div>
<div class="panel panel-info">...</div>
<div class="panel panel-warning">...</div>
<div class="panel panel-danger">...</div>

flash('Message', 'info')
flash('Message', 'success')
flash('Message', 'danger')
flash('Message', 'warning')
flash()->overlay('Modal Message', 'Modal Title')
flash('Message')->important()
-->

{{--<p>Here</p>--}}
@include('flash::message')

@if (isset($errors) && $errors->any())
    <div class="alert alert-danger">
        <strong>Whoops! Something went wrong!</strong>

        @foreach ($errors->all() as $error)
            <br/>{!! $error !!}
        @endforeach
    </div>
@endif
