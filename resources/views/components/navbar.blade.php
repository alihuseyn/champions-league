<nav class="navbar navbar-light bg-info">
    <span class="navbar-brand mb-0 h1">
        @if($menu['home'] ?? false)
            <a class="text-decoration-none text-white mr-1" href="{{ route('play') }}">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif
        <a class="text-white text-decoration-none" href="{{ $route ?? '#' }}">
            @if($icon ?? false)
                <i class="{{ $icon }}"></i>
            @endif
            {{ $title }}
        </a>
    </span>
    <span class="navbar-text">
        @if($menu['settings'] ??  true)
            <a class="text-white" href="{{ route('settings') }}">
                <i class="fas fa-cogs"></i>
            </a>
        @endif
    </span>
</nav>
