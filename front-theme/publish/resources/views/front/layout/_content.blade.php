<div class="container-fluid content-bar">
    <div class="row">
        <div class="container">
            @include('front.layout.content._page_header_bar')
            <div class="row">
                @if( isset($leftColDisable) || (isset($leftColStatus) && $leftColStatus == 'show'))
                    <div class="col-1 col-md-3 left-sidebar">
                        <div class="panel panel-default">
                            @include('front.layout.content._left_sidebar')
                        </div>
                    </div>
                    <div class="col-2 col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-body" id="pjax-container">
                                @include('core.includes._messages')
                                @yield('content')
                            </div>
                        </div>
                    </div>
                @elseif( ! isset($leftColDisable) || (isset($leftColStatus) && $leftColStatus == 'show'))
                    <div class="col-1 col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body" id="pjax-container">
                                @include('core.includes._messages')
                                @yield('content')
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>