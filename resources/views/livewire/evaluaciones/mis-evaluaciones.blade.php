<div class="space-y-6">
    {{-- Encabezado principal --}}
    <section class="overflow-hidden rounded-2xl bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-6 py-4 text-white shadow-lg">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                    Portal de evaluaciones
                </p>

                <h1 class="mt-1.5 text-2xl font-black tracking-tight">
                    Mis evaluaciones
                </h1>

                <p class="mt-1.5 max-w-2xl text-sm leading-5 text-blue-100">
                    Consulte las evaluaciones que tiene asignadas y complete
                    cada formulario según el puesto de la persona evaluada.
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
        {{-- Mensaje para usuarios sin empleado asociado --}}
        <section class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
            <h2 class="text-lg font-black text-amber-950">
                Usuario sin empleado asociado
            </h2>

            <p class="mt-2 text-sm leading-6 text-amber-900">
                Su cuenta existe, pero todavía no tiene un puesto asignado.
                Solicite apoyo a la persona administradora del sistema.
            </p>
        </section>
    @else
        {{-- Tarjetas de resumen --}}
        <section class="grid gap-3 md:grid-cols-3">
            {{-- Pendientes --}}
            <article class="relative overflow-hidden rounded-2xl bg-white px-5 py-3.5 shadow-sm ring-1 ring-slate-200">
                <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-blue-100 blur-3xl"></div>

                <div class="relative flex items-center gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-700 text-white shadow-md shadow-blue-700/20">
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
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-blue-700">
                            Pendientes
                        </p>

                        <div class="mt-0.5 flex items-baseline gap-2">
                            <p class="text-2xl font-black text-slate-950">
                                {{ $evaluacionesPendientes->count() }}
                            </p>

                            <p class="text-xs text-slate-500">
                                Formularios por responder
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Finalizadas --}}
            <article class="relative overflow-hidden rounded-2xl bg-white px-5 py-3.5 shadow-sm ring-1 ring-slate-200">
                <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-emerald-100 blur-3xl"></div>

                <div class="relative flex items-center gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/20">
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

                        <div class="mt-0.5 flex items-baseline gap-2">
                            <p class="text-2xl font-black text-slate-950">
                                {{ $evaluacionesFinalizadas->count() }}
                            </p>

                            <p class="text-xs text-slate-500">
                                Formularios completados
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Puesto --}}
            <article class="relative overflow-hidden rounded-2xl bg-white px-5 py-3.5 shadow-sm ring-1 ring-slate-200">
                <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-indigo-100 blur-3xl"></div>

                <div class="relative flex items-center gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-600/20">
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
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-indigo-700">
                            Mi puesto
                        </p>

                        <p class="mt-1 text-sm font-black leading-5 text-slate-950">
                            {{ $empleado->puesto->nombre }}
                        </p>

                        <p class="mt-0.5 text-xs text-slate-500">
                            {{ $empleado->puesto->codigo }}
                        </p>
                    </div>
                </div>
            </article>
        </section>

        {{-- Evaluaciones pendientes --}}
        <section class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:p-5">
            <div class="flex flex-col gap-2 border-b border-slate-200 pb-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-700">
                        Tareas asignadas
                    </p>

                    <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                        Evaluaciones pendientes
                    </h2>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Seleccione una evaluación para comenzar a responderla.
                    </p>
                </div>

                <span class="w-fit rounded-full bg-blue-50 px-3 py-1 text-[11px] font-bold text-blue-700">
                    {{ $evaluacionesPendientes->count() }}
                    {{ $evaluacionesPendientes->count() === 1 ? 'pendiente' : 'pendientes' }}
                </span>
            </div>

            <div class="mt-4 grid gap-3 lg:grid-cols-2">
                @forelse ($evaluacionesPendientes as $evaluacion)
                    @php
                        $codigoPlantilla = $evaluacion->plantilla->codigo;

                        $estilo = match ($codigoPlantilla) {
                            'GER' => [
                                'etiqueta' => 'Evaluación gerencial',
                                'fondo' => 'bg-blue-50',
                                'texto' => 'text-blue-700',
                                'borde' => 'ring-blue-200',
                                'boton' => 'bg-blue-700 hover:bg-blue-800',
                            ],
                            'MM' => [
                                'etiqueta' => 'Mandos medios',
                                'fondo' => 'bg-indigo-50',
                                'texto' => 'text-indigo-700',
                                'borde' => 'ring-indigo-200',
                                'boton' => 'bg-indigo-700 hover:bg-indigo-800',
                            ],
                            default => [
                                'etiqueta' => 'Personal operativo',
                                'fondo' => 'bg-cyan-50',
                                'texto' => 'text-cyan-700',
                                'borde' => 'ring-cyan-200',
                                'boton' => 'bg-cyan-700 hover:bg-cyan-800',
                            ],
                        };
                    @endphp

                    <article class="group relative overflow-hidden rounded-xl bg-white px-4 py-3 shadow-sm ring-1 {{ $estilo['borde'] }} transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full {{ $estilo['fondo'] }} blur-3xl"></div>

                        <div class="relative">
                            {{-- Encabezado compacto --}}
                            <div class="flex items-center justify-between gap-2">
                                <span class="rounded-full {{ $estilo['fondo'] }} px-2.5 py-1 text-[10px] font-black uppercase tracking-wide {{ $estilo['texto'] }}">
                                    {{ $codigoPlantilla }}
                                </span>

                                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700">
                                    Pendiente
                                </span>
                            </div>

                            {{-- Información principal --}}
                            <div class="mt-2.5">
                                <h3 class="text-base font-black leading-tight text-slate-950">
                                    {{ $evaluacion->evaluado->usuario->name }}
                                </h3>

                                <p class="mt-0.5 text-xs font-semibold {{ $estilo['texto'] }}">
                                    {{ $evaluacion->evaluado->puesto->nombre }}
                                </p>

                                <p class="mt-1 text-[11px] leading-4 text-slate-500">
                                    {{ $evaluacion->plantilla->nombre }}
                                </p>
                            </div>

                            {{-- Pie de tarjeta --}}
                            <div class="mt-2.5 flex items-center justify-between gap-3 border-t border-slate-100 pt-2.5">
                                <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    {{ $estilo['etiqueta'] }}
                                </span>

                                <a
                                     href="{{ route('evaluaciones.responder', $evaluacion) }}"
                                     class="rounded-lg {{ $estilo['boton'] }} px-3 py-1.5 text-[11px] font-black text-white shadow-sm transition"
                                >
                                    Responder
                                </a>

                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-emerald-300 bg-emerald-50 p-4 lg:col-span-2">
                        <h3 class="text-sm font-black text-emerald-950">
                            No tiene evaluaciones pendientes
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-emerald-800">
                            Todas las evaluaciones asignadas han sido completadas.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Evaluaciones finalizadas --}}
        <section class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 sm:p-6">
            <div class="border-b border-slate-200 pb-4">
                <p class="text-[11px] font-black uppercase tracking-[0.2em] text-emerald-700">
                    Historial
                </p>

                <h2 class="mt-1.5 text-2xl font-black tracking-tight text-slate-950">
                    Evaluaciones finalizadas
                </h2>
            </div>

            <div class="mt-4 space-y-3">
                @forelse ($evaluacionesFinalizadas as $evaluacion)
                    <article class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-black text-slate-900">
                                {{ $evaluacion->evaluado->usuario->name }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $evaluacion->evaluado->puesto->nombre }}
                            </p>
                        </div>

                        <div class="text-xs text-slate-500">
                            {{ $evaluacion->fecha_finalizacion?->format('d/m/Y H:i') }}
                        </div>
                    </article>
                @empty
                    <p class="rounded-xl bg-slate-50 p-4 text-sm leading-6 text-slate-500">
                        Todavía no ha finalizado ninguna evaluación.
                    </p>
                @endforelse
            </div>
        </section>
    @endif
</div>