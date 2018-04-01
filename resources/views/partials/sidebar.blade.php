<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            @auth
                @foreach ([
                    'circle' => ['fas fa-circle-notch', 'Circles'],
                    'author' => ['fas fa-user-circle', 'Authors'],
                    'story' => ['fas fa-book', 'Stories'],
                ] as $name => $info)

                    @php list($icon, $title) = $info; @endphp

                    <li>
                        <a class="nav-link" href="{{ route($name . '.index') }}">
                            <i class="{{ $icon }}"></i>
                            @lang($title)
                                <span class="badge badge-pill badge-info">{{ $count[$name] }}</span>
                        </a>
                    </li>
                @endforeach
            @endauth

            <li>
                <a class="nav-link" href="{{ route('published') }}">
                    <i class="fas fa-unlock-alt"></i>
                    Öffentlich
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{ route('doc') }}">
                    <i class="fas fa-file-alt"></i>
                    <strong>Anleitung</strong>
                </a>
            </li>
        </ul>
    </div>
</nav>
