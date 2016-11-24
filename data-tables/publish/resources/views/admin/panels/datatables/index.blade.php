@extends( $masterView )

@section('after-styles-end')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.css"
          media="screen" title="no title" charset="utf-8">
    <style>
        body div#app div.vuetable-pagination {
            border-top: 0;
        }
    </style>
@endsection

@section('content')

    <div id="app">
        <messages></messages>
        <errors></errors>
        <div class="panel-heading h1-panel">
            <h1>
                {{ core()->h1($h1) }}
                {{ isset($h1Small) ? '<small>'.$h1Small.'</small>' : null }}
            </h1>
        </div>
        <collection></collection>
    </div>
    <script src="/js/admin/datatables/apps/index.js"></script>

@endsection
