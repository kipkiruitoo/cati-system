 <ul class="nav navbar-nav">
 @foreach($items as $menu_item)
            <li class>
                <a href="{{ $menu_item->url }}">
                <span class="icon  {{ $menu_item->icon_class }}"></span>
                <span class="title">{{ $menu_item->title }}</span>
                </a>
            </li>
@endforeach
        </ul>