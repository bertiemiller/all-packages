<ul>
    <li class="{{ Active::pattern('/') }}"><a href="/">Home</a></li>
    @if(Route::getRoutes()->hasNamedRoute('auth.subscribe'))
        <li>{!! link_to_route('auth.subscribe', 'Subscribe') !!}</li>
    @endif
    @if(Route::getRoutes()->hasNamedRoute('login'))
        @if (Auth::guest())
            <li class="{{ Active::pattern('login') }}">{!! link_to_route('login', 'Login') !!}</li>
        @else
            @if(Route::getRoutes()->hasNamedRoute('topicmine.core.admin.dashboard.index'))
                <li class="{{ Active::pattern('admin/dashboard') }}">{!! link_to_route('topicmine.core.admin.dashboard.index', 'Admin Dashboard') !!}</li>
            @endif
            <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endif
    @endif
</ul>

@if(config('core.menu.admin.sidebar'))
    <aside class="main-sidebar" id="wrapper">
        <section class="sidebar">
            @foreach (config('core.menu.admin.sidebar') as $packageMenu)
                @adminsection( $packageMenu['section'] )
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>{{ $packageMenu['name'] }}</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu {{ Active::pattern($packageMenu['active_pattern'], 'menu-open') }}"
                        style="display: none; {{ Active::pattern($packageMenu['active_pattern'], 'display: block;') }}">
                        @foreach($packageMenu['menu_items'] as $menuItem)
                            <li class="{{ Active::pattern(isset($menuItem['active_pattern']) ? $menuItem['active_pattern'] : preg_replace('/^\//','',$menuItem['url']) .'*') }}">
                                <a href="{!! url($menuItem['url']) !!}">
                                    <i class="fa fa-circle-o"></i>
                                    {{$menuItem['name']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @endauth
            @endforeach
        </section>
    </aside>
@endif
