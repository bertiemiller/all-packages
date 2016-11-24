@extends($masterView)

@section('content')
    <div class="panel-heading">
        <h1>{{ core()->h1($h1) }}</h1>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                @if(count($data) > 0)
                    <thead class="thead-default">
                    <tr>
                        @foreach($data as $k=>$row)
                            @foreach((is_array($row) ? $row : $row->toArray()) as $key=>$cell)
                                <!-- prevents errors when models are passed through -->
                                @if(is_string($cell) or is_int($cell))<th>{!! $key !!}</th>
                                    @else<th>{Model Cell}</th>
                                    @endif
                            @endforeach
                            @break
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k=>$row)
                        <tr>
                            @foreach((is_array($row) ? $row : $row->toArray()) as $key=>$cell)
                                <!-- prevents errors when models are passed through -->
                                @if(is_string($cell) or is_int($cell))<td>{{$cell}}</td>
                                @else<th>{Model Data}</th>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tr>
                        <td>No data to show</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

@endsection
