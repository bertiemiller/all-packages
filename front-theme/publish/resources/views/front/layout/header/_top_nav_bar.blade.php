<div class="container top-nav-bar hidden-xs">
    <div class="navbar-header">
        <a class="navbar-brand pjax" href="{!! route('home') !!}">
            <img src="/front-theme/images/early-bird.png" alt="{!! app_name() !!}"/>
        </a>
        @include('front.layout.header._form_search')
    </div>
    <ul class="nav navbar-nav navbar-right">
        @if(Route::getRoutes()->hasNamedRoute('login'))
            @if (! auth()->check())
                <li>{!! link_to_route('login', 'Login') !!}</li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        @hasPermission('view-admin')
                        <li>{!! link_to_route('topicmine.admin.dashboard.index', 'Administration') !!}</li>
                        @endauth
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
        @endif
    </ul>
</div>