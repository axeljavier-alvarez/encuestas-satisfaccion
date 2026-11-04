<div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-6 sm:px-4">

    {{-- Encabezado institucional --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        {{-- Logo y título --}}
        <div class="flex items-center gap-4">
            <div class="flex h-20 w-20 shrink-0 items-center justify-center">
                <img src="{{ asset('images/icono_muni.png') }}"
                    alt="Municipalidad de Guatemala"
                    class="h-[75px] w-[75px] object-contain">
            </div>

            <div class="min-w-0">
                <flux:heading size="xl" level="1">
                    Empleados
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    Administre los usuarios del sistema, sus puestos y permisos administrativos.
                </flux:text>
            </div>
        </div>

        {{-- Contadores y botones --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center lg:shrink-0">

            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span>
                    <strong class="font-semibold text-emerald-700">
                        {{ $totalActivos }}
                    </strong>
                    activos
                </span>

                <span class="text-slate-300">·</span>

                <span>
                    <strong class="font-semibold text-red-600">
                        {{ $totalInactivos }}
                    </strong>
                    inactivos
                </span>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <flux:button icon="briefcase" wire:click="gestionarPuestos">
                    Gestionar puestos
                </flux:button>

                <flux:button icon="plus" variant="primary" wire:click="crear">
                    Nuevo empleado
                </flux:button>
            </div>

        </div>
    </div>

    {{-- Mensajes --}}
    @if (session()->has('mensaje'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- CONTENEDOR BLANCO: FILTROS Y TABLA --}}
    <div class="space-y-5 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 dark:bg-zinc-900 dark:ring-zinc-700">

        {{-- Filtros --}}
        <div class="filtros-empleados">

            <div class="filtro-buscar">
                <flux:input
                    label="Buscar empleado"
                    icon="magnifying-glass"
                    placeholder="Nombre, correo o puesto..."
                    wire:model.live.debounce.300ms="buscar"
                />
            </div>

            <div class="filtro-estado">
                <flux:select label="Estado" wire:model.live="filtroEstado">
                    <flux:select.option value="todos">Todos</flux:select.option>
                    <flux:select.option value="activos">Activos</flux:select.option>
                    <flux:select.option value="inactivos">Inactivos</flux:select.option>
                </flux:select>
            </div>

            <div class="filtro-acceso">
                <flux:select label="Acceso" wire:model.live="filtroAcceso">
                    <flux:select.option value="todos">Todos</flux:select.option>
                    <flux:select.option value="administradores">Administradores</flux:select.option>
                    <flux:select.option value="usuarios">Usuarios</flux:select.option>
                </flux:select>
            </div>

            <div class="filtro-limpiar">
                <flux:button icon="x-mark" variant="ghost" wire:click="limpiarFiltros">
                    Limpiar
                </flux:button>
            </div>

            <div class="filtro-paginacion">
                <flux:select wire:model.live="porPagina" aria-label="Registros por página">
                    <flux:select.option value="10">10 por página</flux:select.option>
                    <flux:select.option value="25">25 por página</flux:select.option>
                    <flux:select.option value="50">50 por página</flux:select.option>
                </flux:select>
            </div>

        </div>

        {{-- Separador --}}
        <div class="border-t border-slate-200 dark:border-zinc-700"></div>

        {{-- Tabla de empleados --}}
        <div class="overflow-x-auto">

            <flux:table :paginate="$empleados" responsive>

                {{-- Encabezados --}}
                <flux:table.columns>
                    <flux:table.column>Empleado</flux:table.column>
                    <flux:table.column>Puesto</flux:table.column>
                    <flux:table.column>Acceso</flux:table.column>
                    <flux:table.column>Estado</flux:table.column>
                    <flux:table.column align="end">Acciones</flux:table.column>
                </flux:table.columns>

                {{-- Registros --}}
                <flux:table.rows>
                    @forelse ($empleados as $empleado)

                        <flux:table.row wire:key="empleado-{{ $empleado->id }}">

                            {{-- Nombre y correo --}}
                            <flux:table.cell>
                                <div class="font-semibold text-slate-900 dark:text-white">
                                    {{ $empleado->usuario?->name ?? 'Sin usuario' }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $empleado->usuario?->email }}
                                </div>
                            </flux:table.cell>

                            {{-- Puesto asignado --}}
                            <flux:table.cell>
                                {{ $empleado->puesto?->nombre ?? 'Sin puesto' }}
                            </flux:table.cell>

                            {{-- Permisos de acceso --}}
                            <flux:table.cell>
                                <flux:badge size="sm"
                                    :color="$empleado->usuario?->es_admin ? 'blue' : 'zinc'">
                                    {{ $empleado->usuario?->es_admin ? 'Administrador' : 'Usuario' }}
                                </flux:badge>
                            </flux:table.cell>

                            {{-- Estado actual --}}
                            <flux:table.cell>
                                <flux:badge size="sm" variant="pill"
                                    :color="$empleado->activo ? 'green' : 'red'">
                                    {{ $empleado->activo ? 'Activo' : 'Inactivo' }}
                                </flux:badge>
                            </flux:table.cell>

                            {{-- Acciones --}}
                            <flux:table.cell align="end">
                                <div class="flex items-center justify-end gap-2">

                                    <flux:button
                                        size="sm"
                                        variant="subtle"
                                        icon="pencil-square"
                                        wire:click="editar({{ $empleado->id }})">
                                        Editar
                                    </flux:button>

                                    <flux:button
                                        size="sm"
                                        variant="subtle"
                                        wire:click="cambiarEstadoEmpleado({{ $empleado->id }})">
                                        {{ $empleado->activo ? 'Desactivar' : 'Activar' }}
                                    </flux:button>

                                </div>
                            </flux:table.cell>

                        </flux:table.row>

                    @empty

                        <flux:table.row>
                            <flux:table.cell colspan="5" class="py-10 text-center">
                                <p class="text-sm font-semibold text-slate-700 dark:text-zinc-300">
                                    No se encontraron empleados.
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Modifique los filtros o registre un nuevo empleado.
                                </p>
                            </flux:table.cell>
                        </flux:table.row>

                    @endforelse
                </flux:table.rows>

            </flux:table>

        </div>

    </div>

</div>