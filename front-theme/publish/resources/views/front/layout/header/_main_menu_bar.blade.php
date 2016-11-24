<nav class="navbar navbar-default main-menu-bar">
    <div class="container">
        <ul class="nav nav-justified">
            <li>
                <div class="pull-left title-sm hidden-sm hidden-md hidden-lg">
                    <a href="/">
                        <img src="/images/early-bird.png" alt="{!! app_name() !!}"/>
                    </a>
                </div>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#front-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </li>
        </ul>
        <div class="collapse navbar-collapse" id="front-navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="hidden-sm hidden-md hidden-lg"><a href="/">Home</a></li>
                    @foreach ($_menu_ul as $_menu_li => $v)
                        <li><a href="{{rtrim(parse_url($v->post_name, PHP_URL_PATH),"/")}}">{{$v->post_title}}</a></li>
                    @endforeach
                <li class="hidden-sm hidden-md hidden-lg">
                    @include('front.layout.header._form_search')
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="demo">
                    <a href="/demo" class="col2">
                        <button type="button" class="btn btn-primary btn-sm btn-demo">
                            Early Bird Demo
                        </button>
                    </a>
                </li>
            </ul>
            <br class="hidden-sm hidden-md hidden-lg"/>
        </div>
    </div>
</nav>
