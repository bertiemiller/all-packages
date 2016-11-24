@foreach($data['inputs'] as $name=>$input)
    <tr>
        <td>
            @include('admin.panels.admin-theme.form._form_inputs')
        </td>
    </tr>
@endforeach
