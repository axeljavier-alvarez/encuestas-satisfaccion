<div class="mx-auto w-full max-w-7xl px-2 sm:px-4">
    @php
        $clasesEstado = fn (string $estilo) => match ($estilo) {
            'emerald' => [
                'fondo' => 'bg-emerald-50',
                'texto' => 'text-emerald-700',
                'borde' => 'border-emerald-200',
                'barra' => 'bg-emerald-500',
            ],
            'blue' => [
                'fondo' => 'bg-blue-50',
                'texto' => 'text-blue-700',
                'borde' => 'border-blue-200',
                'barra' => 'bg-blue-500',
            ],
            'amber' => [
                'fondo' => 'bg-amber-50',
                'texto' => 'text-amber-700',
                'borde' => 'border-amber-200',
                'barra' => 'bg-amber-500',
            ],
            default => [
                'fondo' => 'bg-red-50',
                'texto' => 'text-red-700',
                'borde' => 'border-red-200',
                'barra' => 'bg-red-500',
            ],
        };
    @endphp

    {{-- Encabezado principal --}}
    <section class="overflow-hidden rounded-2xl bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-6 py-4 text-white shadow-lg">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                    Portal de evaluaciones
                </p>

                <h1 class="mt-1.5 text-2xl font-black tracking-tight">
                    Mis resultados
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-5 text-blue-100">
                    Consulte su calificación recibida y los resultados de las
                    evaluaciones realizadas a su equipo de trabajo.
                </p>
            </div>

            @if ($empleado)
                <div class="rounded-xl bg-white/10 px-4 py-2.5 ring-1 ring-white/10 backdrop-blur">
                    <p class="text-[9px] font-bold uppercase tracking-wide text-blue-200">
                        Usuario conectado
                    </p>

                    <p class="mt-1 text-sm font-black">
                        {{ $usuario->name }}
                    </p>

                    <p class="mt-0.5 text-xs text-blue-100">
                        {{ $empleado->puesto->nombre }}
                    </p>
                </div>
            @endif
        </div>
    </section>

    @if (! $empleado)
        <section class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
            <h2 class="text-lg font-black text-amber-950">
                Usuario sin empleado asociado
            </h2>

            <p class="mt-2 text-sm leading-6 text-amber-900">
                Su cuenta existe, pero todavía no tiene un puesto asignado.
                Solicite apoyo a la persona administradora del sistema.
            </p>
        </section>
    @else
        {{-- Resultado consolidado recibido --}}
        <section class="mt-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <div class="flex flex-col gap-3 border-b border-slate-200 pb-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-700">
                        Evaluaciones recibidas
                    </p>

                    <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                        Mi calificación consolidada
                    </h2>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Resultado calculado con las evaluaciones finalizadas
                        que otras personas han realizado sobre su desempeño.
                    </p>
                </div>

                @if ($resultadoRecibido)
                    <span class="w-fit rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                        {{ $resultadoRecibido['cantidad_evaluaciones'] }}
                        {{ $resultadoRecibido['cantidad_evaluaciones'] === 1 ? 'evaluación recibida' : 'evaluaciones recibidas' }}
                    </span>
                @endif
            </div>

            @if ($resultadoRecibido)
                @php
                    $estadoRecibido = $clasesEstado(
                        $resultadoRecibido['estado']['estilo']
                    );

                    $porcentajeRecibido = min(
                        100,
                        max(0, ($resultadoRecibido['promedio_general'] / 4) * 100)
                    );
                @endphp

                <div class="mt-4 grid gap-4 lg:grid-cols-[280px_1fr]">
                    {{-- Resumen principal --}}
                    <article class="rounded-2xl bg-slate-950 p-5 text-white">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-blue-200">
                            Promedio general
                        </p>

                        <p class="mt-2 text-5xl font-black tracking-tight">
                            {{ number_format($resultadoRecibido['promedio_general'], 2) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-300">
                            Escala de 1.00 a 4.00
                        </p>

                        <div class="mt-4 h-2 overflow-hidden rounded-full bg-white/10">
                            <div
                                class="h-full rounded-full {{ $estadoRecibido['barra'] }}"
                                style="width: {{ $porcentajeRecibido }}%"
                            ></div>
                        </div>

                        <span class="mt-4 inline-flex rounded-full {{ $estadoRecibido['fondo'] }} px-3 py-1.5 text-xs font-black {{ $estadoRecibido['texto'] }}">
                            {{ $resultadoRecibido['estado']['nombre'] }}
                        </span>

                        <p class="mt-2 text-xs text-slate-300">
                            {{ $resultadoRecibido['estado']['descripcion'] }}
                        </p>
                    </article>

                    {{-- Resultado por dimensión --}}
                    <article class="overflow-hidden rounded-2xl border border-slate-200">
                        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                            <h3 class="text-sm font-black text-slate-950">
                                Resultado recibido por dimensión
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                La suma incluye las respuestas de todas las
                                evaluaciones recibidas y finalizadas.
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-left">
                                <thead class="bg-white">
                                    <tr class="text-[10px] font-black uppercase tracking-wide text-slate-400">
                                        <th class="px-4 py-3">Dimensión</th>
                                        <th class="px-4 py-3 text-center">Suma</th>
                                        <th class="px-4 py-3 text-center">Respuestas</th>
                                        <th class="px-4 py-3 text-center">Promedio</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @foreach ($resultadoRecibido['dimensiones'] as $dimension)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <p class="text-sm font-bold text-slate-800">
                                                    {{ $dimension['nombre'] }}
                                                </p>

                                                @if ($dimension['factor'])
                                                    <p class="mt-0.5 text-xs text-slate-500">
                                                        Factor: {{ $dimension['factor'] }}
                                                    </p>
                                                @endif
                                            </td>

                                            <td class="px-4 py-3 text-center text-sm font-black text-slate-700">
                                                {{ $dimension['suma'] }}
                                            </td>

                                            <td class="px-4 py-3 text-center text-sm text-slate-500">
                                                {{ $dimension['cantidad_respuestas'] }}
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-black text-blue-700">
                                                    {{ number_format($dimension['promedio'], 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </article>
                </div>
            @else
                <div class="mt-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5">
                    <h3 class="text-sm font-black text-slate-800">
                        Todavía no hay resultados disponibles
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Su calificación aparecerá cuando otra persona finalice
                        una evaluación sobre su desempeño.
                    </p>
                </div>
            @endif
        </section>

        {{-- Quiénes evaluaron al usuario --}}
        <section class="mt-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <div class="border-b border-slate-200 pb-3">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-700">
                    Detalle recibido
                </p>

                <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                    Evaluaciones recibidas individualmente
                </h2>
            </div>

            <div class="mt-4 space-y-3">
                @forelse ($evaluacionesRecibidas as $registro)
                    @php
                        $evaluacion = $registro['evaluacion'];
                        $resultado = $registro['resultado'];
                        $estado = $clasesEstado($resultado['estado']['estilo']);
                    @endphp

                    <details class="group rounded-xl border border-slate-200 bg-slate-50">
                        <summary class="flex cursor-pointer list-none flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-black text-slate-900">
                                    {{ $evaluacion->evaluador->usuario->name }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    {{ $evaluacion->evaluador->puesto->nombre }}
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full {{ $estado['fondo'] }} px-3 py-1 text-[11px] font-black {{ $estado['texto'] }}">
                                    {{ number_format($resultado['promedio_general'], 2) }}
                                </span>

                                <span class="rounded-full {{ $estado['fondo'] }} px-3 py-1 text-[11px] font-bold {{ $estado['texto'] }}">
                                    {{ $resultado['estado']['nombre'] }}
                                </span>

                                <span class="text-xs font-black text-slate-400 transition group-open:rotate-180">
                                    ▼
                                </span>
                            </div>
                        </summary>

                        <div class="border-t border-slate-200 bg-white px-4 py-3">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-100 text-left">
                                    <thead>
                                        <tr class="text-[10px] font-black uppercase tracking-wide text-slate-400">
                                            <th class="pb-2">Dimensión</th>
                                            <th class="pb-2 text-center">Suma</th>
                                            <th class="pb-2 text-center">Preguntas</th>
                                            <th class="pb-2 text-center">Promedio</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-slate-100">
                                        @foreach ($resultado['dimensiones'] as $dimension)
                                            <tr>
                                                <td class="py-2.5 text-sm font-semibold text-slate-700">
                                                    {{ $dimension['nombre'] }}
                                                </td>

                                                <td class="py-2.5 text-center text-sm text-slate-600">
                                                    {{ $dimension['suma'] }}
                                                </td>

                                                <td class="py-2.5 text-center text-sm text-slate-500">
                                                    {{ $dimension['cantidad_preguntas'] }}
                                                </td>

                                                <td class="py-2.5 text-center text-sm font-black text-blue-700">
                                                    {{ number_format($dimension['promedio'], 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </details>
                @empty
                    <p class="rounded-xl bg-slate-50 p-4 text-xs leading-5 text-slate-500">
                        Todavía no existen evaluaciones finalizadas sobre su desempeño.
                    </p>
                @endforelse
            </div>
        </section>

        {{-- Resultados del equipo --}}
        <section class="mt-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <div class="flex flex-col gap-3 border-b border-slate-200 pb-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-700">
                        Equipo de trabajo
                    </p>

                    <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                        Resultados de mis subordinados
                    </h2>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Se muestran únicamente las evaluaciones que usted ya finalizó
                        sobre sus subordinados directos.
                    </p>
                </div>

                <span class="w-fit rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                    {{ $resultadosEquipo->count() }}
                    {{ $resultadosEquipo->count() === 1 ? 'resultado' : 'resultados' }}
                </span>
            </div>

            <div class="mt-4 space-y-3">
                @forelse ($resultadosEquipo as $registro)
                    @php
                        $evaluacion = $registro['evaluacion'];
                        $resultado = $registro['resultado'];
                        $estado = $clasesEstado($resultado['estado']['estilo']);
                    @endphp

                    <details class="group rounded-xl border border-slate-200 bg-slate-50">
                        <summary class="flex cursor-pointer list-none flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-black text-slate-900">
                                    {{ $evaluacion->evaluado->usuario->name }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    {{ $evaluacion->evaluado->puesto->nombre }}
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full {{ $estado['fondo'] }} px-3 py-1 text-[11px] font-black {{ $estado['texto'] }}">
                                    {{ number_format($resultado['promedio_general'], 2) }}
                                </span>

                                <span class="rounded-full {{ $estado['fondo'] }} px-3 py-1 text-[11px] font-bold {{ $estado['texto'] }}">
                                    {{ $resultado['estado']['nombre'] }}
                                </span>

                                <span class="text-xs font-black text-slate-400 transition group-open:rotate-180">
                                    ▼
                                </span>
                            </div>
                        </summary>

                        <div class="border-t border-slate-200 bg-white px-4 py-3">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-100 text-left">
                                    <thead>
                                        <tr class="text-[10px] font-black uppercase tracking-wide text-slate-400">
                                            <th class="pb-2">Dimensión</th>
                                            <th class="pb-2 text-center">Suma</th>
                                            <th class="pb-2 text-center">Preguntas</th>
                                            <th class="pb-2 text-center">Promedio</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-slate-100">
                                        @foreach ($resultado['dimensiones'] as $dimension)
                                            <tr>
                                                <td class="py-2.5 text-sm font-semibold text-slate-700">
                                                    {{ $dimension['nombre'] }}
                                                </td>

                                                <td class="py-2.5 text-center text-sm text-slate-600">
                                                    {{ $dimension['suma'] }}
                                                </td>

                                                <td class="py-2.5 text-center text-sm text-slate-500">
                                                    {{ $dimension['cantidad_preguntas'] }}
                                                </td>

                                                <td class="py-2.5 text-center text-sm font-black text-blue-700">
                                                    {{ number_format($dimension['promedio'], 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </details>
                @empty
                    <p class="rounded-xl bg-slate-50 p-4 text-xs leading-5 text-slate-500">
                        Todavía no ha finalizado evaluaciones sobre sus subordinados directos.
                    </p>
                @endforelse
            </div>
        </section>

        {{-- Escala de interpretación --}}
        <section class="mt-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <div class="border-b border-slate-200 pb-3">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">
                    Referencia
                </p>

                <h2 class="mt-1 text-lg font-black tracking-tight text-slate-950">
                    Escala de interpretación
                </h2>
            </div>

            <div class="mt-3 grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl bg-emerald-50 px-3 py-2.5 text-xs text-emerald-800">
                    <p class="font-black">3.50 – 4.00</p>
                    <p class="mt-0.5">Desempeño sobresaliente</p>
                </div>

                <div class="rounded-xl bg-blue-50 px-3 py-2.5 text-xs text-blue-800">
                    <p class="font-black">2.50 – 3.49</p>
                    <p class="mt-0.5">Cumple lo esperado</p>
                </div>

                <div class="rounded-xl bg-amber-50 px-3 py-2.5 text-xs text-amber-800">
                    <p class="font-black">1.50 – 2.49</p>
                    <p class="mt-0.5">Necesita mejora</p>
                </div>

                <div class="rounded-xl bg-red-50 px-3 py-2.5 text-xs text-red-800">
                    <p class="font-black">1.00 – 1.49</p>
                    <p class="mt-0.5">Desempeño deficiente</p>
                </div>
            </div>
        </section>
    @endif
</div>