@extends( $masterView )

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
        <edit-form></edit-form>
    </div>
    <script src="/js/admin/datatables/apps/edit.js"></script>

@endsection
