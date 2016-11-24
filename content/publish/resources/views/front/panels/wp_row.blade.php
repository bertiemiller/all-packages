@extends( $masterView )

@section('content')
    <div class="panel-body">
        {!!   $containerTagOpen !!}
        {!! html_entity_decode($item->post_content) !!}
        {!! $containerTagClose !!}
        <hr/>
    </div>
@endsection
