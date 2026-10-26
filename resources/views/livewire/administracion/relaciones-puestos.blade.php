<div class="mx-auto w-full max-w-7xl px-2 sm:px-4">
    {{-- Encabezado --}}
    <section class="overflow-hidden rounded-2xl bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-6 py-4 text-white shadow-lg">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                    Administración
                </p>

                <h1 class="mt-1.5 text-2xl font-black tracking-tight">
                    Relaciones entre puestos
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-5 text-blue-100">
                    Defina qué puestos deben evaluar a otros puestos y qué plantilla debe usarse en cada relación.
                </p>
            </div>

            <button
                type="button"
                wire:click="crear"
                class="w-fit rounded-lg bg-white px-4 py-2 text-xs font-black text-blue-900 shadow-sm transition hover:bg-blue-50"
            >
                + Nueva relación
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
                    Reglas de evaluación
                </p>

                <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                    Listado de relaciones
                </h2>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Cada registro representa una dirección específica:
                    puesto evaluador hacia puesto evaluado.
                </p>
            </div>

            <div class="w-full sm:w-80">
                <label
                    for="buscar"
                    class="text-[10px] font-black uppercase tracking-wide text-slate-500"
                >
                    Buscar relación
                </label>

                <input
                    id="buscar"
                    type="text"
                    wire:model.live.debounce.300ms="buscar"
                    placeholder="Código, puesto o plantilla..."
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
                            Puesto evaluador
                        </th>

                        <th class="px-4 py-3 text-center">
                            Relación
                        </th>

                        <th class="px-4 py-3">
                            Puesto evaluado
                        </th>

                        <th class="px-4 py-3">
                            Plantilla
                        </th>

                        <th class="px-4 py-3 text-center">
                            Tipo
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
                    @forelse ($relaciones as $relacion)
                        @php
                            $codigoPlantillaRelacion = $relacion->plantilla?->codigo ?? 'SIN';

                            $estiloPlantillaRelacion = match ($codigoPlantillaRelacion) {
                                'GER', 'LIDERGER' => 'bg-blue-50 text-blue-700',
                                'MM', 'LIDERMM' => 'bg-indigo-50 text-indigo-700',
                                'OPA', 'OPE' => 'bg-cyan-50 text-cyan-700',
                                default => 'bg-slate-100 text-slate-600',
                            };

                            $textoTipoRelacion = $tiposRelacion[$relacion->tipo_relacion] ?? 'Sin definir';

                            $estiloTipoRelacion = match ($relacion->tipo_relacion) {
                                'descendente' => 'bg-emerald-50 text-emerald-700',
                                'ascendente' => 'bg-amber-50 text-amber-700',
                                'lateral' => 'bg-purple-50 text-purple-700',
                                default => 'bg-slate-100 text-slate-600',
                            };
                        @endphp

                        <tr
                            wire:key="relacion-{{ $relacion->id }}"
                            class="transition hover:bg-slate-50"
                        >
                            {{-- Puesto evaluador --}}
                            <td class="px-4 py-3">
                                <p class="text-sm font-black text-slate-900">
                                    {{ $relacion->puestoEvaluador->nombre }}
                                </p>

                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <span class="text-[11px] font-bold text-slate-500">
                                        {{ $relacion->puestoEvaluador->codigo }}
                                    </span>
                                </div>
                            </td>

                            {{-- Flecha --}}
                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-lg font-black text-slate-500">
                                    →
                                </span>
                            </td>

                            {{-- Puesto evaluado --}}
                            <td class="px-4 py-3">
                                <p class="text-sm font-black text-slate-900">
                                    {{ $relacion->puestoEvaluado->nombre }}
                                </p>

                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <span class="text-[11px] font-bold text-slate-500">
                                        {{ $relacion->puestoEvaluado->codigo }}
                                    </span>
                                </div>
                            </td>

                            {{-- Plantilla de la relación --}}
                            <td class="whitespace-nowrap px-4 py-3">
                                @if ($relacion->plantilla)
                                    <span class="rounded-full px-2.5 py-1 text-[10px] font-black uppercase tracking-wide {{ $estiloPlantillaRelacion }}">
                                        {{ $relacion->plantilla->codigo }}
                                    </span>

                                    <p class="mt-1 text-[11px] font-bold text-slate-500">
                                        {{ $relacion->plantilla->nombre }}
                                    </p>
                                @else
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-black uppercase tracking-wide text-red-700">
                                        Sin plantilla
                                    </span>
                                @endif
                            </td>

                            {{-- Tipo de relación --}}
                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-wide {{ $estiloTipoRelacion }}">
                                    {{ $textoTipoRelacion }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                @if ($relacion->activo)
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-emerald-700">
                                        Activa
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-slate-500">
                                        Inactiva
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="whitespace-nowrap px-4 py-3 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="editar({{ $relacion->id }})"
                                        class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-[11px] font-black text-slate-700 transition hover:bg-slate-100"
                                    >
                                        Editar
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="cambiarEstado({{ $relacion->id }})"
                                        wire:confirm="¿Está seguro de cambiar el estado de esta relación?"
                                        class="
                                            rounded-lg px-3 py-1.5 text-[11px] font-black text-white transition
                                            {{ $relacion->activo
                                                ? 'bg-red-600 hover:bg-red-700'
                                                : 'bg-emerald-600 hover:bg-emerald-700'
                                            }}
                                        "
                                    >
                                        {{ $relacion->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center">
                                <p class="text-sm font-black text-slate-700">
                                    No se encontraron relaciones
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Cambie el texto de búsqueda o registre una nueva relación.
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
                {{ $relaciones->count() }}
                {{ $relaciones->count() === 1 ? 'relación' : 'relaciones' }}
            </span>
        </div>
    </section>

    {{-- Modal reutilizable --}}
    @if ($mostrarModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-4 py-6 backdrop-blur-sm"
            wire:click.self="cerrarModal"
        >
            <section class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
                {{-- Encabezado --}}
                <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-5 py-4 text-white">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-200">
                                Regla de evaluación
                            </p>

                            <h2 class="mt-1 text-xl font-black">
                                {{ $relacionId ? 'Editar relación' : 'Nueva relación' }}
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
                <form wire:submit="guardar" class="space-y-4 p-5">
                    {{-- Puesto evaluador --}}
                    <div>
                        <label
                            for="puestoEvaluadorId"
                            class="text-xs font-black uppercase tracking-wide text-slate-600"
                        >
                            Puesto evaluador
                        </label>

                        <select
                            id="puestoEvaluadorId"
                            wire:model="puestoEvaluadorId"
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="">
                                Seleccione el puesto que realizará la evaluación
                            </option>

                            @foreach ($puestos as $puesto)
                                <option value="{{ $puesto->id }}">
                                    {{ $puesto->codigo }}
                                    ·
                                    {{ $puesto->nombre }}
                                    {{ $puesto->activo ? '' : '· INACTIVO' }}
                                </option>
                            @endforeach
                        </select>

                        @error('puestoEvaluadorId')
                            <p class="mt-1.5 text-xs font-bold text-red-700">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Indicador visual --}}
                    <div class="flex justify-center">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-xl font-black text-blue-700">
                            ↓
                        </span>
                    </div>

                    {{-- Puesto evaluado --}}
                    <div>
                        <label
                            for="puestoEvaluadoId"
                            class="text-xs font-black uppercase tracking-wide text-slate-600"
                        >
                            Puesto evaluado
                        </label>

                        <select
                            id="puestoEvaluadoId"
                            wire:model="puestoEvaluadoId"
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="">
                                Seleccione el puesto que recibirá la evaluación
                            </option>

                            @foreach ($puestos as $puesto)
                                <option value="{{ $puesto->id }}">
                                    {{ $puesto->codigo }}
                                    ·
                                    {{ $puesto->nombre }}
                                    {{ $puesto->activo ? '' : '· INACTIVO' }}
                                </option>
                            @endforeach
                        </select>

                        @error('puestoEvaluadoId')
                            <p class="mt-1.5 text-xs font-bold text-red-700">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Plantilla y tipo --}}
                    <div class="grid gap-4 sm:grid-cols-2">
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
                                    Seleccione plantilla
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

                        <div>
                            <label
                                for="tipoRelacion"
                                class="text-xs font-black uppercase tracking-wide text-slate-600"
                            >
                                Tipo de relación
                            </label>

                            <select
                                id="tipoRelacion"
                                wire:model="tipoRelacion"
                                class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            >
                                <option value="">
                                    Seleccione tipo
                                </option>

                                @foreach ($tiposRelacion as $valor => $texto)
                                    <option value="{{ $valor }}">
                                        {{ $texto }}
                                    </option>
                                @endforeach
                            </select>

                            @error('tipoRelacion')
                                <p class="mt-1.5 text-xs font-bold text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Explicación --}}
                    <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">
                        <p class="text-xs font-black text-blue-900">
                            ¿Qué significa esta relación?
                        </p>

                        <p class="mt-1 text-xs leading-5 text-blue-700">
                            El puesto evaluador responderá una evaluación sobre el puesto evaluado.
                            La plantilla se toma desde esta relación específica, no desde el puesto evaluado.
                        </p>
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
                                Relación activa
                            </span>

                            <span class="block text-xs text-slate-500">
                                Las relaciones activas pueden utilizarse para generar evaluaciones pendientes.
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