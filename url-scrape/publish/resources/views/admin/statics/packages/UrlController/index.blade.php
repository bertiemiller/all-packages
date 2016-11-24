@extends($masterView)

@section('title', 'Items')

@section('content')
    <div class="panel-heading h1-panel">
        <h1>Scrape Urls</h1>
    </div>
    <div class="panel-body">
        <div class="box">
            <div class="box-body">
                <table class="table table-striped table-bordered table-hover">
                    @foreach($data as $i=>$item)
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            {!! Form::label('url['.$item['id'].']', 'Item Id '.$item['id'], ['class' => 'col-md-2 control-label']) !!}
                                            <div class="col-md-4">
                                                {!! Form::text('url['.$item['id'].']', $item['url'], ['class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-md-6">
                                                <div class="pull-left">
                                                    {!! Form::open(['url' => route( core()->routeBase().'.scrape', $item['id']), '_method' => 'POST']) !!}
                                                    {!! Form::submit('Url Scrape', array('class' => 'btn btn-primary')) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="pull-left">
                                                    <a href="{{ route( core()->routeBase().'.urlResults', $item['id']) }}"
                                                       class="btn btn-primary"
                                                       role="button">Url Results</a>
                                                </div>
                                                <div class="pull-left">
                                                    {!! Form::open(['url' => route( core()->routeBase().'.jsScrape', $item['id']), '_method' => 'POST']) !!}
                                                    {!! Form::submit('JS Scrape & Results', array('class' => 'btn btn-primary')) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <div class="row">
                                <div class="form-horizontal">
                                    <div class="col-md-10 col-md-offset-2">
                                        <a href="{{ core()->routeCreate() }}" class="pull-left">
                                            <button type="button" class="btn btn-primary">Create</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
