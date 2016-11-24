<div class="content-wrapper text-eb-green">
    @if(section_exists('page-header'))
        <section class="content-header">
            <div class="panel-body">
                @yield('page-header')
            </div>
        </section>
    @endif
    <section class="content">
        @include('core.includes._messages')
        <div class="content-section">
            @yield('content')
        </div>
    </section>
</div>