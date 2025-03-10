@php
    $configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/home') }}" class="app-brand-link">
                <img src="{{ asset('img/averclaro.png') }}" alt="" width="210px">
            </a>

        </div>
    @endif

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        @foreach ($filteredMenu as $menu)
            @php
                $menuId = 'menu-' . Str::slug($menu['name']); // ID único para cada menú
                $activeClass = Route::currentRouteName() === $menu['slug'] ? 'active' : '';
            @endphp

            <li class="menu-item {{ $activeClass }}">
                <a href="javascript:void(0);" class="menu-link {{ isset($menu['submenu']) ? 'menu-toggle' : '' }}"
                    @if (isset($menu['submenu'])) data-bs-toggle="collapse" data-bs-target="#{{ $menuId }}" aria-expanded="false" @endif>

                    @isset($menu['icon'])
                        <i class="{{ $menu['icon'] }}"></i>
                    @endisset
                    <div>{{ $menu['name'] }}</div>

                    {{-- Flecha personalizada (única) --}}
                    @isset($menu['submenu'])
                        <i class="mdi mdi-chevron-right ms-auto arrow-icon"></i>
                    @endisset
                </a>

                @isset($menu['submenu'])
                    <ul id="{{ $menuId }}" class="submenu collapse">
                        @foreach ($menu['submenu'] as $submenu)
                            <li class="submenu-item">
                                <a href="{{ url($submenu['url']) }}" class="menu-link">
                                    <div>{{ $submenu['name'] }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endisset
            </li>
        @endforeach
    </ul>

    {{-- 🔧 CSS corregido dentro del mismo archivo --}}
    <style>
        /* 🔹 Oculta cualquier flecha duplicada generada por Bootstrap u otro framework */
        .menu-toggle::after {
            display: none !important;
        }

        /* 🔹 Rotación de la flecha al expandir el menú */
        .menu-item .arrow-icon {
            transition: transform 0.3s ease;
        }

        .menu-toggle[aria-expanded="true"] .arrow-icon {
            transform: rotate(90deg);
        }

        /* 🔹 Quitar los puntos del submenú */
        .submenu {
            list-style: none;
            padding-left: 15px;
            /* Opcional: Espaciado para que el submenú se vea más organizado */
        }

        .submenu-item {
            list-style: none;
            /* Elimina los puntos del submenú */
        }
    </style>
</aside>
