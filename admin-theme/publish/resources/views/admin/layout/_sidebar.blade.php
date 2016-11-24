<aside class="main-sidebar" id="wrapper">
    <section class="sidebar">
        <ul class="sidebar-menu">
            @include('core.layout.sidebar._main_left_nav')
            @if(config('core.menu.admin.sidebar'))
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
            @endif
        </ul>
        <ul class="sidebar-menu">
            <li>
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas">
                    <i class="fa-collapse fa fa-arrow-circle-left"></i><span>Collpase Menu</span>
                </a>
            </li>
        </ul>
    </section>
</aside>