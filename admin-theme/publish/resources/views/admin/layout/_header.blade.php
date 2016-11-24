<header class="main-header">
    <a href="{!! route('home') !!}" class="logo hidden-xs">
        <span class="logo-mini"><img src="/admin-theme/images/early-bird.png" alt="{!! app_name() !!}"/></span>
        <span class="logo-lg"><img src="/admin-theme/images/early-bird.png" alt="{!! app_name() !!}"/>
        </span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle visible-xs" data-toggle="offcanvas">
            <span class="sr-only">Toggle Navigation</span>
        </a>
        <ul class="nav navbar-left hidden-xs">
            @include('admin.layout.header._search_form')
        </ul>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @include('admin.layout.header._alerts')
            </ul>
        </div>
    </nav>
</header>
