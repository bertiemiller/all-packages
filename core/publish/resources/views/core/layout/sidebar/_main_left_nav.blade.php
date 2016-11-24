<ul class="sidebar-menu">
    {{--<li class="header">HEADER</li>--}}
    <li class="treeview main-menu-selector">
        <a href="#" class="main-menu-item-selected">
            <i class="fa fa-bars"></i>
            <span>Topic Mine</span>
            <i class="fa fa-angle-down pull-right"></i>
        </a>
        <ul class="treeview-menu">

            @if(Route::getRoutes()->hasNamedRoute('topicmine.admin.dashboard.index') )
                <li><a href="{!! route('topicmine.admin.dashboard.index') !!}">
                <i class="fa fa-circle-o"></i>
                    Dashboard</a></li>
            @endif

            @if(Route::getRoutes()->hasNamedRoute('topicmine.sources.dashboard.index') )
                <li><a href="{{route('topicmine.sources.dashboard.index')}}"><i class="fa fa-circle-o"></i>
                        Data Sources</a></li>
            @endif

            @if(Route::getRoutes()->hasNamedRoute('topicmine.models.dashboard.index') )
                <li><a href="{{route('topicmine.models.dashboard.index')}}"><i class="fa fa-circle-o"></i>
                        Modelling</a></li>
            @endif

            @if(Route::getRoutes()->hasNamedRoute('topicmine.analytics.dashboard.index') )
                <li><a href="{{route('topicmine.analytics.dashboard.index')}}"><i class="fa fa-circle-o"></i>
                    Analytics</a></li>
            @endif

            @if(Route::getRoutes()->hasNamedRoute('topicmine.account.dashboard.index') )
                <li><a href="{{route('topicmine.account.dashboard.index')}}"><i class="fa fa-circle-o"></i>
                    My Account</a></li>
            @endif
            {{--<li class="dropdown-header">Data</li>--}}
            {{--<li role="separator" class="divider"></li>--}}
        </ul>
    </li>
</ul>
