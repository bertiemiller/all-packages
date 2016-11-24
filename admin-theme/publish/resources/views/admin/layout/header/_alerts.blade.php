<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {{--        <img src="{!! access()->user()->picture !!}" class="user-image" alt="User Image"/>--}}
        <img src="/images/empty-user-icon.png" class="user-image" alt="User Image"/>
        <span class="hidden-xs">{{ auth_user()->name }}</span>
    </a>

    <ul class="dropdown-menu">
        <li class="user-header">
            {{--<img src="{!! access()->user()->picture !!}" class="img-circle" alt="User Image" />--}}
            <img src="/images/admin-theme/empty-user-icon.png" class="img-circle" alt="User Image"/>
            <p>
                {!! auth_user()->name !!}
            </p>
        </li>

        <li class="user-body">
            <div class="row">
                <div class="col-xs-12 pull-left">
                    <h4>Data</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 text-center">
                    <a href="{{route('topicmine.sources.dashboard.index')}}">Sources</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="{{route('topicmine.models.dashboard.index')}}">Models</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="{{route('topicmine.analytics.dashboard.index')}}">Analytics</a>
                </div>
            </div>
        </li>
        <li class="user-footer">
            <div class="row">
                <div class="col-xs-4 pull-left">
                    <a href="{{route('topicmine.account.dashboard.index')}}" class="btn btn-default btn-flat">My
                        Account</a>
                </div>
                <div class="col-xs-4 pull-right">
                    <a href="{{ url('/logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                       class="btn btn-default btn-flat">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </li>
    </ul>
</li>