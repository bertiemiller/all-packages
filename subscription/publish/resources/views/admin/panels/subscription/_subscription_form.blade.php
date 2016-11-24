
<tr>
    <td>
        <div class="form-group">
            <label class="col-md-4 control-label">Topics</label>
            <div class="col-md-6">
                {!!  Form::select('topics', $data['topics']['options'],
                $data['topics']['value'], ['class' => 'form-control'] )  !!}
            </div>
        </div>
    </td>
</tr>
<tr>
    <td>
        <div class="form-group">
            <label class="col-md-4 control-label">Domains</label>
            <div class="col-md-6">
                {!!  Form::select('domains', $data['domains']['options'],
                $data['domains']['value'], ['class' => 'form-control'] )  !!}
            </div>
        </div>
    </td>
</tr>
