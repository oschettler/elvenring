<div class="sidebar" data-image="img/sidebar-5.jpg">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text">
                @lang(config('app.name', 'Laravel'))
            </a>
        </div>
        <ul class="nav">
            @auth
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>@lang('Home')</p>
                    </a>
                </li>

                @foreach ([
                    'circle' => 'Circles',
                    'author' => 'Authors',
                    'story' => 'Stories',
                ] as $name => $title)

                    <li>
                        <a class="nav-link" href="{{ route($name . '.index') }}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>@lang($title)
                                <span class="entity-count badge badge-pill badge-light">{{ $count[$name] }}</span>
                            </p>
                        </a>
                    </li>
                @endforeach
            @endauth

            <li>
                <a class="nav-link" href="{{ route('published') }}">
                    <i class="nc-icon nc-circle-09"></i>
                    <p>Öffentlich</p>
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{ route('doc') }}">
                    <i class="nc-icon nc-circle-09"></i>
                    <p><strong>Anleitung</strong></p>
                </a>
            </li>
        </ul>
    </div>
</div>
