<div class="list-group">
    <a class="list-group-item" href="#">Link 1</a>
    <a class="list-group-item active" href="#">Link 2</a>
    <a class="list-group-item" href="#">Link 3</a>
    <a class="list-group-item" href="#">Link 4</a>
    <a class="list-group-item" href="#">Link 5</a>
    <a class="list-group-item" href="#">Link 6</a>
</div>
@if( ! empty($subMenuItems) )
    <ul class="nav nav-pills nav-stacked">
        @foreach($subMenuItems as $item)
            <li>
                <a href="/{{ $subMenuItemsBasePath }}/{{$item[$itemKeys['slug']] }}" class="pjax">
                    {{$item[$itemKeys['title']]}}
                </a>
            </li>
        @endforeach
    </ul>
@endif
