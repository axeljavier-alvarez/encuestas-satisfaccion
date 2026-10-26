<div class="mx-auto w-full max-w-7xl px-2 sm:px-4">
    {{-- Encabezado --}}
    <section class="overflow-hidden rounded-2xl bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-6 py-4 text-white shadow-lg">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                    Administración
                </p>

                <h1 class="mt-1.5 text-2xl font-black tracking-tight">
                    Puestos
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-5 text-blue-100">
                    Administre los puestos de la organización y asigne la
                    plantilla de evaluación correspondiente.
                </p>
            </div>

            <button
                type="button"
                wire:click="crear"
                class="w-fit rounded-lg bg-white px-4 py-2 text-xs font-black text-blue-900 shadow-sm transition hover:bg-blue-50"
            >
                + Nuevo puesto
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
        {{-- Barra superior --}}
        <div class="flex flex-col gap-3 border-b border-slate-200 pb-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-700">
                    Catálogo organizacional
                </p>

                <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                    Listado de puestos
                </h2>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Puede buscar, crear, editar o cambiar el estado de un puesto.
                </p>
            </div>

            <div class="w-full sm:w-80">
                <label
                    for="buscar"
                    class="text-[10px] font-black uppercase tracking-wide text-slate-500"
                >
                    Buscar puesto
                </label>

                <input
                    id="buscar"
                    type="text"
                    wire:model.live.debounce.300ms="buscar"
                    placeholder="Código o nombre..."
                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                >
            </div>
        </div>

        {{-- Tabla --}}
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left">
                <thead class="bg-slate-50">
                    <tr class="text-[10px] font-black uppercase tracking-wide text-slate-500">
                        <th class="rounded-s-lg px-4 py-3">
                            Código
                        </th>

                        <th class="px-4 py-3">
                            Puesto
                        </th>

                        <th class="px-4 py-3">
                            Plantilla
                        </th>

                        <th class="px-4 py-3 text-center">
                            Estado
                        </th>

                        <th class="rounded-e-lg px-4 py-3 text-end">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($puestos as $puesto)
                        @php
                            $estiloPlantilla = match ($puesto->plantilla->codigo) {
                                'GER' => 'bg-blue-50 text-blue-700',
                                'MM' => 'bg-indigo-50 text-indigo-700',
                                default => 'bg-cyan-50 text-cyan-700',
                            };
                        @endphp

                        <tr
                            wire:key="puesto-{{ $puesto->id }}"
                            class="transition hover:bg-slate-50"
                        >
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="text-xs font-black text-slate-700">
                                    {{ $puesto->codigo }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <p class="text-sm font-bold text-slate-900">
                                    {{ $puesto->nombre }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-wide {{ $estiloPlantilla }}">
                                    {{ $puesto->plantilla->codigo }}
                                </span>

                                <p class="mt-1 text-[11px] text-slate-500">
                                    {{ $puesto->plantilla->nombre }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                @if ($puesto->activo)
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-emerald-700">
                                        Activo
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-slate-500">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="editar({{ $puesto->id }})"
                                        class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-[11px] font-black text-slate-700 transition hover:bg-slate-100"
                                    >
                                        Editar
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="cambiarEstado({{ $puesto->id }})"
                                        wire:confirm="¿Está seguro de cambiar el estado de este puesto?"
                                        class="
                                            rounded-lg px-3 py-1.5 text-[11px] font-black text-white transition
                                            {{ $puesto->activo
                                                ? 'bg-red-600 hover:bg-red-700'
                                                : 'bg-emerald-600 hover:bg-emerald-700'
                                            }}
                                        "
                                    >
                                        {{ $puesto->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="px-4 py-8 text-center"
                            >
                                <p class="text-sm font-black text-slate-700">
                                    No se encontraron puestos
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Cambie el texto de búsqueda o registre un nuevo puesto.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Total --}}
        <div class="mt-4 flex justify-end border-t border-slate-100 pt-3">
            <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-bold text-slate-600">
                {{ $puestos->count() }}
                {{ $puestos->count() === 1 ? 'puesto' : 'puestos' }}
            </span>
        </div>
    </section>

    {{-- Modal para crear o editar --}}
    @if ($mostrarModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-4 py-6 backdrop-blur-sm"
            wire:click.self="cerrarModal"
        >
            <section class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
                {{-- Encabezado del modal --}}
                <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-5 py-4 text-white">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-200">
                                Catálogo organizacional
                            </p>

                            <h2 class="mt-1 text-xl font-black">
                                {{ $puestoId ? 'Editar puesto' : 'Nuevo puesto' }}
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

                {{-- Formulario --}}
                <form
                    wire:submit="guardar"
                    class="space-y-4 p-5"
                >
                    {{-- Código --}}
                    <div>
                        <label
                            for="codigo"
                            class="text-xs font-black uppercase tracking-wide text-slate-600"
                        >
                            Código
                        </label>

                        <input
                            id="codigo"
                            type="text"
                            wire:model="codigo"
                            maxlength="30"
                            placeholder="Ej. MM-LOG"
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm uppercase outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        >

                        @error('codigo')
                            <p class="mt-1.5 text-xs font-bold text-red-700">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label
                            for="nombre"
                            class="text-xs font-black uppercase tracking-wide text-slate-600"
                        >
                            Nombre del puesto
                        </label>

                        <input
                            id="nombre"
                            type="text"
                            wire:model="nombre"
                            maxlength="150"
                            placeholder="Ej. Jefe de Logística"
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        >

                        @error('nombre')
                            <p class="mt-1.5 text-xs font-bold text-red-700">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Plantilla --}}
                    <div>
                        <label
                            for="plantillaId"
                            class="text-xs font-black uppercase tracking-wide text-slate-600"
                        >
                            Plantilla de evaluación
                        </label>

                        <select
                            id="plantillaId"
                            wire:model="plantillaId"
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="">
                                Seleccione una plantilla
                            </option>

                            @foreach ($plantillas as $plantilla)
                                <option value="{{ $plantilla->id }}">
                                    {{ $plantilla->codigo }}
                                    ·
                                    {{ $plantilla->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('plantillaId')
                            <p class="mt-1.5 text-xs font-bold text-red-700">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <input
                            type="checkbox"
                            wire:model="activo"
                            class="h-4 w-4 rounded border-slate-300 text-blue-700 focus:ring-blue-600"
                        >

                        <span>
                            <span class="block text-sm font-black text-slate-800">
                                Puesto activo
                            </span>

                            <span class="block text-xs text-slate-500">
                                Los puestos activos pueden utilizarse en empleados y evaluaciones.
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