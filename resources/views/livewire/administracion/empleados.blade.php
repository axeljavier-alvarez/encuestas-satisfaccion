<div class="mx-auto w-full max-w-7xl px-2 sm:px-4">
    {{-- Encabezado --}}
    <section class="overflow-hidden rounded-2xl bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-6 py-4 text-white shadow-lg">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                    Administración
                </p>

                <h1 class="mt-1.5 text-2xl font-black tracking-tight">
                    Empleados
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-5 text-blue-100">
                    Administre los usuarios del sistema, sus puestos,
                    jefaturas y permisos administrativos.
                </p>
            </div>

            <button
                type="button"
                wire:click="crear"
                class="w-fit rounded-lg bg-white px-4 py-2 text-xs font-black text-blue-900 shadow-sm transition hover:bg-blue-50"
            >
                + Nuevo empleado
            </button>
        </div>
    </section>

    {{-- Mensaje de confirmación --}}
    @if (session('mensaje'))
        <section class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800">
            {{ session('mensaje') }}
        </section>
    @endif

    {{-- Contenedor principal --}}
    <section class="mt-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-col gap-3 border-b border-slate-200 pb-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-700">
                    Estructura organizacional
                </p>

                <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                    Listado de empleados
                </h2>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Puede buscar, registrar, editar o cambiar el estado de un empleado.
                </p>
            </div>

            <div class="w-full sm:w-80">
                <label
                    for="buscar"
                    class="text-[10px] font-black uppercase tracking-wide text-slate-500"
                >
                    Buscar empleado
                </label>

                <input
                    id="buscar"
                    type="text"
                    wire:model.live.debounce.300ms="buscar"
                    placeholder="Nombre, correo o puesto..."
                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                >
            </div>
        </div>

        {{-- Tabla --}}
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left">
                <thead class="bg-slate-50">
                    <tr class="text-[10px] font-black uppercase tracking-wide text-slate-500">
                        <th class="rounded-s-lg px-4 py-3">Empleado</th>
                        <th class="px-4 py-3">Puesto</th>
                        <th class="px-4 py-3">Jefe inmediato</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="rounded-e-lg px-4 py-3 text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($empleados as $empleado)
                        @php
                            $codigoPlantilla = $empleado->puesto->plantilla->codigo;

                            $estiloPlantilla = match ($codigoPlantilla) {
                                'GER' => 'bg-blue-50 text-blue-700',
                                'MM' => 'bg-indigo-50 text-indigo-700',
                                default => 'bg-cyan-50 text-cyan-700',
                            };
                        @endphp

                        <tr
                            wire:key="empleado-{{ $empleado->id }}"
                            class="transition hover:bg-slate-50"
                        >
                            {{-- Empleado --}}
                            <td class="px-4 py-3">
                                <p class="text-sm font-black text-slate-900">
                                    {{ $empleado->usuario->name }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    {{ $empleado->usuario->email }}
                                </p>

                                @if ($empleado->usuario->es_admin)
                                    <span class="mt-1 inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wide text-blue-700">
                                        Administrador
                                    </span>
                                @endif
                            </td>

                            {{-- Puesto --}}
                            <td class="px-4 py-3">
                                <p class="text-sm font-bold text-slate-800">
                                    {{ $empleado->puesto->nombre }}
                                </p>

                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <span class="text-[11px] font-bold text-slate-500">
                                        {{ $empleado->puesto->codigo }}
                                    </span>

                                    <span class="rounded-full px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wide {{ $estiloPlantilla }}">
                                        {{ $codigoPlantilla }}
                                    </span>
                                </div>
                            </td>

                            {{-- Jefe inmediato --}}
                            <td class="px-4 py-3">
                                @if ($empleado->jefe)
                                    <p class="text-sm font-bold text-slate-800">
                                        {{ $empleado->jefe->usuario->name }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500">
                                        {{ $empleado->jefe->puesto->nombre }}
                                    </p>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-slate-500">
                                        Sin jefe inmediato
                                    </span>
                                @endif
                            </td>

                            {{-- Estado --}}
                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                @if ($empleado->activo)
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-emerald-700">
                                        Activo
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-slate-500">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="whitespace-nowrap px-4 py-3 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="editar({{ $empleado->id }})"
                                        class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-[11px] font-black text-slate-700 transition hover:bg-slate-100"
                                    >
                                        Editar
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="cambiarEstado({{ $empleado->id }})"
                                        wire:confirm="¿Está seguro de cambiar el estado de este empleado?"
                                        class="
                                            rounded-lg px-3 py-1.5 text-[11px] font-black text-white transition
                                            {{ $empleado->activo
                                                ? 'bg-red-600 hover:bg-red-700'
                                                : 'bg-emerald-600 hover:bg-emerald-700'
                                            }}
                                        "
                                    >
                                        {{ $empleado->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center">
                                <p class="text-sm font-black text-slate-700">
                                    No se encontraron empleados
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Cambie el texto de búsqueda o registre un nuevo empleado.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end border-t border-slate-100 pt-3">
            <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-bold text-slate-600">
                {{ $empleados->count() }}
                {{ $empleados->count() === 1 ? 'empleado' : 'empleados' }}
            </span>
        </div>
    </section>

    {{-- Modal reutilizable --}}
    @if ($mostrarModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-4 py-6 backdrop-blur-sm"
            wire:click.self="cerrarModal"
        >
            <section class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
                <div class="sticky top-0 z-10 bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-5 py-4 text-white">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-200">
                                Estructura organizacional
                            </p>

                            <h2 class="mt-1 text-xl font-black">
                                {{ $empleadoId ? 'Editar empleado' : 'Nuevo empleado' }}
                            </h2>
                        </div>

                        <button
                            type="button"
                            wire:click="cerrarModal"
                            class="rounded-lg bg-white/10 px-3 py-1.5 text-sm font-black text-white transition hover:bg-white/20"
                        >
                            ✕
                        </button>
                    </div>
                </div>

                <form wire:submit="guardar" class="space-y-4 p-5">
                    {{-- Datos de acceso --}}
                    <section class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-blue-700">
                            Datos de acceso
                        </p>

                        <div class="mt-3 grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="nombre" class="text-xs font-black uppercase tracking-wide text-slate-600">
                                    Nombre completo
                                </label>

                                <input
                                    id="nombre"
                                    type="text"
                                    wire:model="nombre"
                                    maxlength="150"
                                    placeholder="Ej. Carlos Pérez"
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >

                                @error('nombre')
                                    <p class="mt-1.5 text-xs font-bold text-red-700">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="correo" class="text-xs font-black uppercase tracking-wide text-slate-600">
                                    Correo electrónico
                                </label>

                                <input
                                    id="correo"
                                    type="email"
                                    wire:model="correo"
                                    maxlength="255"
                                    placeholder="usuario@empresa.com"
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >

                                @error('correo')
                                    <p class="mt-1.5 text-xs font-bold text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="password" class="text-xs font-black uppercase tracking-wide text-slate-600">
                                    {{ $empleadoId ? 'Nueva contraseña opcional' : 'Contraseña inicial' }}
                                </label>

                                <input
                                    id="password"
                                    type="password"
                                    wire:model="password"
                                    autocomplete="new-password"
                                    placeholder="{{ $empleadoId ? 'Dejar vacío para conservar la actual' : 'Mínimo 8 caracteres' }}"
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >

                                @error('password')
                                    <p class="mt-1.5 text-xs font-bold text-red-700">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="text-xs font-black uppercase tracking-wide text-slate-600">
                                    Confirmar contraseña
                                </label>

                                <input
                                    id="password_confirmation"
                                    type="password"
                                    wire:model="password_confirmation"
                                    autocomplete="new-password"
                                    placeholder="Repita la contraseña"
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >
                            </div>
                        </div>
                    </section>

                    {{-- Información organizacional --}}
                    <section class="rounded-xl border border-slate-200 bg-white p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-indigo-700">
                            Información organizacional
                        </p>

                        <div class="mt-3 grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="puestoId" class="text-xs font-black uppercase tracking-wide text-slate-600">
                                    Puesto
                                </label>

                                <select
                                    id="puestoId"
                                    wire:model="puestoId"
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                >
                                    <option value="">Seleccione un puesto</option>

                                    @foreach ($puestos as $puesto)
                                        <option value="{{ $puesto->id }}">
                                            {{ $puesto->codigo }}
                                            ·
                                            {{ $puesto->nombre }}
                                            ·
                                            {{ $puesto->plantilla->codigo }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('puestoId')
                                    <p class="mt-1.5 text-xs font-bold text-red-700">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jefeId" class="text-xs font-black uppercase tracking-wide text-slate-600">
                                    Jefe inmediato
                                </label>

                                <select
                                    id="jefeId"
                                    wire:model="jefeId"
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                >
                                    <option value="">Sin jefe inmediato</option>

                                    @foreach ($jefes as $jefe)
                                        <option value="{{ $jefe->id }}">
                                            {{ $jefe->usuario->name }}
                                            ·
                                            {{ $jefe->puesto->nombre }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('jefeId')
                                    <p class="mt-1.5 text-xs font-bold text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    {{-- Permiso administrativo --}}
                    <label class="flex items-center gap-3 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">
                        <input
                            type="checkbox"
                            wire:model="esAdmin"
                            class="h-4 w-4 rounded border-blue-300 text-blue-700 focus:ring-blue-600"
                        >

                        <span>
                            <span class="block text-sm font-black text-blue-900">
                                Usuario administrador
                            </span>

                            <span class="block text-xs leading-5 text-blue-700">
                                Permite acceder a las pantallas administrativas del sistema.
                            </span>
                        </span>
                    </label>

                    @error('esAdmin')
                        <p class="text-xs font-bold text-red-700">{{ $message }}</p>
                    @enderror

                    {{-- Estado --}}
                    <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <input
                            type="checkbox"
                            wire:model="activo"
                            class="h-4 w-4 rounded border-slate-300 text-blue-700 focus:ring-blue-600"
                        >

                        <span>
                            <span class="block text-sm font-black text-slate-800">
                                Empleado activo
                            </span>

                            <span class="block text-xs text-slate-500">
                                Los empleados activos pueden ingresar y participar en evaluaciones.
                            </span>
                        </span>
                    </label>

                    {{-- Botones --}}
                    <div class="flex flex-col-reverse gap-2 border-t border-slate-100 pt-4 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            wire:click="cerrarModal"
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-black text-slate-700 transition hover:bg-slate-50"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="rounded-lg bg-blue-700 px-4 py-2 text-xs font-black text-white shadow-sm transition hover:bg-blue-800 disabled:cursor-wait disabled:opacity-60"
                        >
                            <span wire:loading.remove wire:target="guardar">
                                Guardar cambios
                            </span>

                            <span wire:loading wire:target="guardar">
                                Guardando...
                            </span>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    @endif
</div>