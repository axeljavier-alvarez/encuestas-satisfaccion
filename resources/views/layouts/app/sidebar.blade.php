<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    <style>
        /* SIDEBAR INSTITUCIONAL */
        .sidebar-institucional {
            background-color: #273385 !important;
            color: #ffffff !important;
            border-right: none !important;
        }

        /* TEXTOS Y ELEMENTOS DEL SIDEBAR */
        .sidebar-institucional,
        .sidebar-institucional a,
        .sidebar-institucional button,
        .sidebar-institucional [data-flux-sidebar-item],
        .sidebar-institucional [data-flux-sidebar-group-heading] {
            color: #ffffff !important;
        }

        /* ICONOS */
        .sidebar-institucional [data-flux-sidebar-item] svg {
            color: #ffffff !important;
        }

        /* TÍTULOS DE GRUPOS */
        .sidebar-institucional [data-flux-sidebar-group-heading] {
            color: #dce3ff !important;
            font-weight: 700 !important;
        }

        /* EFECTO HOVER */
        .sidebar-institucional [data-flux-sidebar-item]:hover {
            background-color: rgba(255, 255, 255, 0.13) !important;
            color: #ffffff !important;
            border-radius: 8px;
        }

        /* ELEMENTO ACTIVO */
        .sidebar-institucional [data-flux-sidebar-item][data-current] {
            background-color: rgba(255, 255, 255, 0.20) !important;
            color: #ffffff !important;
            border-radius: 8px;
            font-weight: 700 !important;
        }

        /* MENÚ DE USUARIO */
        .sidebar-institucional [data-flux-profile] {
            color: #ffffff !important;
        }

        /* SEPARADORES */
        .sidebar-institucional [data-flux-sidebar-header] {
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        /* MENÚ DESPLEGABLE DEL PERFIL */
        ui-menu[data-flux-menu].menu-perfil {
            background-color: #273385 !important;
            color: #ffffff !important;
        }

        /* TODOS LOS TEXTOS DEL MENÚ */
        ui-menu[data-flux-menu].menu-perfil [data-flux-heading],
        ui-menu[data-flux-menu].menu-perfil [data-flux-text],
        ui-menu[data-flux-menu].menu-perfil [data-flux-menu-item] {
            color: #ffffff !important;
        }

        /* NOMBRE, CORREO Y ELEMENTOS INTERNOS */
        ui-menu[data-flux-menu].menu-perfil [data-flux-heading] *,
        ui-menu[data-flux-menu].menu-perfil [data-flux-text] *,
        ui-menu[data-flux-menu].menu-perfil [data-flux-menu-item] * {
            color: #ffffff !important;
        }

        /* ICONOS */
        ui-menu[data-flux-menu].menu-perfil [data-flux-menu-item] svg {
            color: #ffffff !important;
        }

        /* EFECTO AL PASAR EL MOUSE */
        ui-menu[data-flux-menu].menu-perfil [data-flux-menu-item]:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
        }

        /* SEPARADORES */
        ui-menu[data-flux-menu].menu-perfil [data-flux-menu-separator] {
            border-color: rgba(255, 255, 255, 0.20) !important;
        }

        /* PERFIL DEL USUARIO EN LA PARTE INFERIOR DEL SIDEBAR */
        .sidebar-institucional [data-flux-sidebar-profile],
        .sidebar-institucional [data-flux-sidebar-profile] * {
            color: #ffffff !important;
        }

        /* NOMBRE DEL USUARIO Y FLECHA */
        .sidebar-institucional [data-flux-profile],
        .sidebar-institucional [data-flux-profile] * {
            color: #ffffff !important;
        }

        /* ICONOS DEL PERFIL */
        .sidebar-institucional [data-flux-profile] svg {
            color: #ffffff !important;
        }

        .filtros-empleados {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            flex-wrap: nowrap;
            gap: 16px;
            width: 100%;
        }

        .filtro-buscar {
            flex: 1 1 auto;
            min-width: 0;
        }

        .filtro-estado {
            flex: 0 0 145px;
        }

        .filtro-acceso {
            flex: 0 0 165px;
        }

        .filtro-limpiar {
            flex: 0 0 auto;
        }

        .filtro-paginacion {
            flex: 0 0 135px;
            margin-left: auto;
        }

        @media (max-width: 900px) {
            .filtros-empleados {
                flex-wrap: wrap;
            }

            .filtro-buscar {
                flex: 1 1 100%;
            }

            .filtro-estado,
            .filtro-acceso {
                flex: 1 1 150px;
            }

            .filtro-paginacion {
                margin-left: auto;
            }
        }

        @media (max-width: 600px) {
            .filtros-empleados {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .filtro-buscar,
            .filtro-estado,
            .filtro-acceso,
            .filtro-limpiar,
            .filtro-paginacion {
                width: 100%;
                min-width: 0;
                flex: 0 0 auto;
                margin-left: 0;
            }
        }



        /* =========================================
   ENCABEZADO DE PREGUNTAS
========================================= */

        .encabezado-preguntas {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            width: 100%;
        }

        /* Título */
        .titulo-preguntas {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1 1 auto;
            min-width: 0;
        }

        /* Contenedor de las tres estadísticas */
        .indicadores-preguntas {
            display: grid;
            grid-template-columns: repeat(3, 170px);
            gap: 12px;
            flex-shrink: 0;
        }

        /* Tarjetas del mismo tamaño */
        .tarjeta-estadistica {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            height: 76px;
            min-width: 0;
            padding: 12px;
            border-radius: 12px;
            box-sizing: border-box;
        }

        /* Íconos */
        .icono-estadistica {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            min-width: 38px;
            border-radius: 10px;
        }

        /* Contenido */
        .contenido-estadistica {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }

        /* Etiquetas */
        .etiqueta-estadistica {
            font-size: 11px;
            font-weight: 500;
            line-height: 1.3;
            white-space: nowrap;
        }

        /* Valores */
        .valor-estadistica {
            margin-top: 4px;
            font-size: 24px;
            line-height: 1;
            font-weight: 700;
        }

        /* =========================================
        RESPONSIVE
        ========================================= */

        @media (max-width: 1100px) {

            .encabezado-preguntas {
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
            }

            .titulo-preguntas {
                width: 100%;
                flex: initial;
            }

            .indicadores-preguntas {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                width: 100%;
            }
        }

        @media (max-width: 480px) {

            .indicadores-preguntas {
                gap: 8px;
            }

            .tarjeta-estadistica {
                padding: 10px;
                gap: 7px;
                height: 70px;
            }

            .icono-estadistica {
                width: 30px;
                height: 30px;
                min-width: 30px;
            }

            .etiqueta-estadistica {
                font-size: 10px;
                white-space: normal;
            }

            .valor-estadistica {
                font-size: 20px;
            }
        }


        /* Contenedor de la pregunta */
        .contenido-pregunta {
            width: 320px;
            max-width: 320px;
            min-width: 0;
        }

        /* Texto de la pregunta: máximo 3 líneas */
        .texto-pregunta {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 10;
            line-clamp: 10;

            overflow: hidden;
            overflow-wrap: anywhere;
            white-space: normal;

            font-size: 14px;
            line-height: 1.5;
            font-weight: 500;
        }

        /* Ajustar únicamente la columna Pregunta */
        @media (min-width: 1024px) {

            .tabla-asignadores table:has(.contenido-pregunta) {
                table-layout: auto;
            }

            .tabla-asignadores table:has(.contenido-pregunta) th:nth-child(3),
            .tabla-asignadores table:has(.contenido-pregunta) td:nth-child(3) {
                width: 350px;
                min-width: 350px;
                max-width: 350px;
            }

        }

        /* Espacio derecho para la columna Acciones */
        .tabla-preguntas table th:last-child,
        .tabla-preguntas table td:last-child {
            padding-right: 24px !important;
        }

    </style>
</head>

<body class="min-h-screen bg-slate-100">


    {{-- Menú lateral para computadora --}}
    <flux:sidebar sticky collapsible="mobile" class="sidebar-institucional border-e">

        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('home') }}" wire:navigate />

            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        {{-- Navegación principal --}}
        <flux:sidebar.nav>

            {{-- Portal de encuestas: solo administradores --}}
            @if (auth()->user()?->esAdministrador())
                <flux:sidebar.group heading="Portal de encuestas" class="grid">

                    <flux:sidebar.item icon="home" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>
                        Resumen
                    </flux:sidebar.item>

                </flux:sidebar.group>
            @endif

            {{-- Administración --}}
            @if (auth()->user()?->esAdministrador())
                <flux:sidebar.group heading="Administración" class="grid">

                    <flux:sidebar.item icon="users" :href="route('administracion.asignadores')"
                        :current="request()->routeIs('administracion.asignadores')" wire:navigate>
                        Asignadores
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="document-text" :href="route('administracion.preguntas')"
                        :current="request()->routeIs('administracion.preguntas')" wire:navigate>
                        Preguntas
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="document-text" :href="route('administracion.plantillas')"
                        :current="request()->routeIs('administracion.plantillas')" wire:navigate>
                        Plantillas de evaluación
                    </flux:sidebar.item>

                    {{-- TIPOS DE RESPUESTA --}}

                </flux:sidebar.group>
            @endif

            @if (auth()->user()?->esAsignador())
                <flux:sidebar.group heading="Gestión de encuestas" class="grid">

                    <flux:sidebar.item icon="clipboard-document-list" :href="route('asignador.plantillas')"
                        :current="request()->routeIs('asignador.plantillas')" wire:navigate>
                        Mis plantillas
                    </flux:sidebar.item>

                </flux:sidebar.group>
            @endif

        </flux:sidebar.nav>

        <flux:spacer />

        {{-- Menú del usuario en computadora --}}
        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />

    </flux:sidebar>

    {{-- Encabezado para teléfono y tablet --}}
    <flux:header class="lg:hidden">

        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">

            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu class="menu-perfil">

                {{-- Datos del usuario --}}
                <flux:menu.radio.group>

                    <div class="p-0 text-sm font-normal">

                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">

                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">

                                <flux:heading class="truncate">
                                    {{ auth()->user()->name }}
                                </flux:heading>

                                <flux:text class="truncate">
                                    {{ auth()->user()->email }}
                                </flux:text>

                            </div>

                        </div>

                    </div>

                </flux:menu.radio.group>

                <flux:menu.separator />

                {{-- Configuración --}}
                <flux:menu.radio.group>

                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        Configuración
                    </flux:menu.item>

                </flux:menu.radio.group>

                <flux:menu.separator />

                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf

                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        Cerrar sesión
                    </flux:menu.item>

                </form>

            </flux:menu>

        </flux:dropdown>

    </flux:header>

    {{ $slot }}

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts

</body>

</html>
