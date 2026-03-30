<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
    <ul id="sidebarnav">
        @foreach ($links as $item)
            @if ($item['type'] == 'section')
                <li class="nav-small-cap">
                    <i class="ti {{ $item['icon'] }} nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">{{ $item['title'] }}</span>
                </li>
            @else
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs($item['active']) ? ' active' : '' }}"
                        href="{{ $item['route'] }}" aria-expanded="false">
                        <span>
                            <i class="ti {{ $item['icon'] }}"></i>
                        </span>
                        <span class="hide-menu">{{ $item['name'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
