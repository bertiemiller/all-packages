@extends( $masterView )

@section('content')
    <div class="panel-body">
        {!!   $containerTagOpen !!}
        {!! html_entity_decode($item->post_content) !!}
        {!! $containerTagClose !!}
        <hr/>
        @if(! count($rows) > 0)
            <p>Sorry, nothing to display :( </p>
        @else
            @foreach ($rows as $row)
                <div class="row-fluid">
                    {!! $containerTagOpen !!}
                    {!! $subHeadingOpen !!}
                    <a href="/{{$item->post_name}}/{{$row['slug'] }}">
                        {{ $row['ID'] }} - {{$row['title']}}
                    </a>
                    {!! $subHeadingClose !!}
                    <div class="body">
                        {!! isset($row['body']) ? $row['body'] : $row['content'] !!}
                    </div>
                    {!! $containerTagClose !!}
                </div>
            @endforeach
        @endif
    </div>
@endsection