@php
    $configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="" class="app-brand-link">
                <img src="{{ asset('img/averclaro.png') }}" alt="" width="210px">
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z"
                        fill="currentColor" fill-opacity="0.6" />
                </svg>
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
