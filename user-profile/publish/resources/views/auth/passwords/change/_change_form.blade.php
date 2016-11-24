<div class="panel-heading"><h1>Change Password</h1></div>
<div class="panel-body">
    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    {!! Form::open(['route' => ['topicmine.user_profile.password.update'], 'class' => 'form-horizontal']) !!}
                    <tr>
                        <td>
                            <div class="form-group">
                                {!! Form::label('old_password', 'Old Password', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::input('password', 'old_password', null, ['class' => 'form-control', 'placeholder' => 'Old Password']) !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                {!! Form::label('password', 'New Password', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => 'New Password']) !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                {!! Form::label('password_confirmation', 'New Password Confirmation', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => 'New Password Confirmation']) !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
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