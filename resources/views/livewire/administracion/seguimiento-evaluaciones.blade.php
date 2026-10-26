<div class="mx-auto w-full max-w-7xl px-2 sm:px-4">
    {{-- Encabezado --}}
    <section class="overflow-hidden rounded-2xl bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-6 py-4 text-white shadow-lg">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                    Administración
                </p>

                <h1 class="mt-1.5 text-2xl font-black tracking-tight">
                    Seguimiento de evaluaciones
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-5 text-blue-100">
                    Consulte el avance general del proceso e identifique
                    las evaluaciones pendientes y finalizadas.
                </p>
            </div>

            <span class="w-fit rounded-lg bg-white/10 px-4 py-2 text-xs font-black text-white ring-1 ring-white/20">
                Control de avance
            </span>
        </div>
    </section>

    {{-- Indicadores generales --}}
    <section class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Total --}}
        <article class="relative overflow-hidden rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-slate-200">
            <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-slate-100 blur-3xl"></div>

            <div class="relative flex items-center gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-slate-800 text-white shadow-md">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">
                        Total
                    </p>

                    <p class="mt-0.5 text-2xl font-black text-slate-950">
                        {{ $totalEvaluaciones }}
                    </p>

                    <p class="text-xs text-slate-500">
                        Evaluaciones registradas
                    </p>
                </div>
            </div>
        </article>

        {{-- Pendientes --}}
        <article class="relative overflow-hidden rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-slate-200">
            <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-amber-100 blur-3xl"></div>

            <div class="relative flex items-center gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-md shadow-amber-500/20">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"
                        />
                    </svg>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-amber-700">
                        Pendientes
                    </p>

                    <p class="mt-0.5 text-2xl font-black text-slate-950">
                        {{ $totalPendientes }}
                    </p>

                    <p class="text-xs text-slate-500">
                        Por responder
                    </p>
                </div>
            </div>
        </article>

        {{-- Finalizadas --}}
        <article class="relative overflow-hidden rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-slate-200">
            <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-emerald-100 blur-3xl"></div>

            <div class="relative flex items-center gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/20">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-emerald-700">
                        Finalizadas
                    </p>

                    <p class="mt-0.5 text-2xl font-black text-slate-950">
                        {{ $totalFinalizadas }}
                    </p>

                    <p class="text-xs text-slate-500">
                        Formularios completados
                    </p>
                </div>
            </div>
        </article>

        {{-- Avance --}}
        <article class="relative overflow-hidden rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-slate-200">
            <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-blue-100 blur-3xl"></div>

            <div class="relative">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-blue-700">
                            Avance general
                        </p>

                        <p class="mt-0.5 text-2xl font-black text-slate-950">
                            {{ number_format($porcentajeAvance, 1) }}%
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-700 text-white shadow-md shadow-blue-700/20">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3v18h18M7 16l4-4 3 3 5-6"
                            />
                        </svg>
                    </div>
                </div>

                <div class="mt-3 h-2 overflow-hidden rounded-full bg-blue-100">
                    <div
                        class="h-full rounded-full bg-blue-700 transition-all"
                        style="width: {{ $porcentajeAvance }}%"
                    ></div>
                </div>
            </div>
        </article>
    </section>

    {{-- Contenedor principal --}}
    <section class="mt-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        {{-- Encabezado y filtros --}}
        <div class="border-b border-slate-200 pb-4">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-700">
                    Control del proceso
                </p>

                <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                    Listado general de evaluaciones
                </h2>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Utilice los filtros para localizar evaluaciones específicas
                    y verificar su estado actual.
                </p>
            </div>

            {{-- Filtros --}}
            <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-[1fr_190px_220px_auto] xl:items-end">
                {{-- Buscar --}}
                <div>
                    <label
                        for="buscar"
                        class="text-[10px] font-black uppercase tracking-wide text-slate-500"
                    >
                        Buscar
                    </label>

                    <input
                        id="buscar"
                        type="text"
                        wire:model.live.debounce.300ms="buscar"
                        placeholder="Nombre, código o puesto..."
                        class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                    >
                </div>

                {{-- Estado --}}
                <div>
                    <label
                        for="estado"
                        class="text-[10px] font-black uppercase tracking-wide text-slate-500"
                    >
                        Estado
                    </label>

                    <select
                        id="estado"
                        wire:model.live="estado"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                    >
                        <option value="">
                            Todos los estados
                        </option>

                        <option value="pendiente">
                            Pendientes
                        </option>

                        <option value="finalizada">
                            Finalizadas
                        </option>
                    </select>
                </div>

                {{-- Plantilla --}}
                <div>
                    <label
                        for="plantillaId"
                        class="text-[10px] font-black uppercase tracking-wide text-slate-500"
                    >
                        Plantilla
                    </label>

                    <select
                        id="plantillaId"
                        wire:model.live="plantillaId"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                    >
                        <option value="">
                            Todas las plantillas
                        </option>

                        @foreach ($plantillas as $plantilla)
                            <option value="{{ $plantilla->id }}">
                                {{ $plantilla->codigo }}
                                ·
                                {{ $plantilla->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Limpiar --}}
                <button
                    type="button"
                    wire:click="limpiarFiltros"
                    class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-black text-slate-700 transition hover:bg-slate-50"
                >
                    Limpiar filtros
                </button>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left">
                <thead class="bg-slate-50">
                    <tr class="text-[10px] font-black uppercase tracking-wide text-slate-500">
                        <th class="rounded-s-lg px-4 py-3">
                            Evaluador
                        </th>

                        <th class="px-4 py-3">
                            Evaluado
                        </th>

                        <th class="px-4 py-3">
                            Plantilla
                        </th>

                        <th class="px-4 py-3 text-center">
                            Estado
                        </th>

                        <th class="rounded-e-lg px-4 py-3 text-end">
                            Fecha de finalización
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($evaluaciones as $evaluacion)
                        @php
                            $codigoPlantilla = $evaluacion->plantilla->codigo;

                            $estiloPlantilla = match ($codigoPlantilla) {
                                'GER' => 'bg-blue-50 text-blue-700',
                                'MM' => 'bg-indigo-50 text-indigo-700',
                                default => 'bg-cyan-50 text-cyan-700',
                            };
                        @endphp

                        <tr
                            wire:key="evaluacion-{{ $evaluacion->id }}"
                            class="transition hover:bg-slate-50"
                        >
                            {{-- Evaluador --}}
                            <td class="px-4 py-3">
                                <p class="text-sm font-black text-slate-900">
                                    {{ $evaluacion->evaluador->usuario->name }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    {{ $evaluacion->evaluador->puesto->nombre }}
                                </p>
                            </td>

                            {{-- Evaluado --}}
                            <td class="px-4 py-3">
                                <p class="text-sm font-black text-slate-900">
                                    {{ $evaluacion->evaluado->usuario->name }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    {{ $evaluacion->evaluado->puesto->nombre }}
                                </p>
                            </td>

                            {{-- Plantilla --}}
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-wide {{ $estiloPlantilla }}">
                                    {{ $codigoPlantilla }}
                                </span>

                                <p class="mt-1 text-[11px] text-slate-500">
                                    {{ $evaluacion->plantilla->nombre }}
                                </p>
                            </td>

                            {{-- Estado --}}
                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                @if ($evaluacion->estado === 'finalizada')
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-emerald-700">
                                        Finalizada
                                    </span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-[10px] font-black uppercase tracking-wide text-amber-700">
                                        Pendiente
                                    </span>
                                @endif
                            </td>

                            {{-- Fecha --}}
                            <td class="whitespace-nowrap px-4 py-3 text-end">
                                @if ($evaluacion->fecha_finalizacion)
                                    <p class="text-sm font-bold text-slate-700">
                                        {{ $evaluacion->fecha_finalizacion->format('d/m/Y') }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500">
                                        {{ $evaluacion->fecha_finalizacion->format('H:i') }}
                                    </p>
                                @else
                                    <span class="text-xs font-bold text-slate-400">
                                        —
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="px-4 py-8 text-center"
                            >
                                <p class="text-sm font-black text-slate-700">
                                    No se encontraron evaluaciones
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Modifique los filtros para consultar otros registros.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4 border-t border-slate-100 pt-4">
            {{ $evaluaciones->links() }}
        </div>
    </section>
</div>