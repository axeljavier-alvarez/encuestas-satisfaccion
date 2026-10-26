<div class="mx-auto w-full max-w-5xl px-2 sm:px-4">
    @php
        $codigoPlantilla = $evaluacion->plantilla->codigo;

        $estilo = match ($codigoPlantilla) {
            'GER' => [
                'titulo' => 'Evaluación de desempeño gerencial',
                'descripcion' => 'Instrumento para valorar el desempeño del personal gerencial en función del cumplimiento de metas, liderazgo, competencias y contribución organizacional.',
                'degradado' => 'from-slate-950 via-blue-950 to-indigo-900',
                'texto' => 'text-blue-700',
                'fondo' => 'bg-blue-50',
                'borde' => 'border-blue-200',
                'boton' => 'bg-blue-700 hover:bg-blue-800',
                'anillo' => 'ring-blue-200',
            ],
            'MM' => [
                'titulo' => 'Evaluación de liderazgo · Mandos medios',
                'descripcion' => 'Instrumento para valorar la comunicación, liderazgo, apoyo y gestión del equipo.',
                'degradado' => 'from-slate-950 via-indigo-950 to-blue-900',
                'texto' => 'text-indigo-700',
                'fondo' => 'bg-indigo-50',
                'borde' => 'border-indigo-200',
                'boton' => 'bg-indigo-700 hover:bg-indigo-800',
                'anillo' => 'ring-indigo-200',
            ],
            default => [
                'titulo' => 'Evaluación de desempeño · Personal operativo',
                'descripcion' => 'Instrumento para valorar la comunicación, apoyo laboral, gestión del trabajo y compromiso organizacional.',
                'degradado' => 'from-slate-950 via-cyan-950 to-teal-800',
                'texto' => 'text-cyan-700',
                'fondo' => 'bg-cyan-50',
                'borde' => 'border-cyan-200',
                'boton' => 'bg-cyan-700 hover:bg-cyan-800',
                'anillo' => 'ring-cyan-200',
            ],
        };

        $numerosRomanos = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
        ];
    @endphp

    {{-- Encabezado --}}
    <section class="overflow-hidden rounded-2xl bg-gradient-to-r {{ $estilo['degradado'] }} px-6 py-5 text-white shadow-lg">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                    Portal de evaluaciones
                </p>

                <h1 class="mt-1.5 text-2xl font-black tracking-tight">
                    {{ $estilo['titulo'] }}
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-5 text-slate-200">
                    {{ $estilo['descripcion'] }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <span class="rounded-lg bg-white/10 px-3 py-2 text-xs font-black ring-1 ring-white/20">
                    Plantilla {{ $codigoPlantilla }}
                </span>

                <a
                    href="{{ route('dashboard') }}"
                    class="rounded-lg bg-white/10 px-4 py-2 text-xs font-black text-white ring-1 ring-white/20 transition hover:bg-white/20"
                >
                    Regresar
                </a>
            </div>
        </div>
    </section>

    {{-- Mensaje de confirmación --}}
    @if (session('mensaje'))
        <section class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800">
            {{ session('mensaje') }}
        </section>
    @endif

    {{-- Error general --}}
    @error('respuestas')
        <section class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-800">
            {{ $message }}
        </section>
    @enderror

    {{-- Información de la evaluación --}}
    <section class="mt-4 grid gap-3 md:grid-cols-3">
        <article class="rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-slate-200">
            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-400">
                Persona evaluada
            </p>

            <p class="mt-1 text-sm font-black text-slate-950">
                {{ $evaluacion->evaluado->usuario->name }}
            </p>
        </article>

        <article class="rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-slate-200">
            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-400">
                Puesto evaluado
            </p>

            <p class="mt-1 text-sm font-black text-slate-950">
                {{ $evaluacion->evaluado->puesto->nombre }}
            </p>
        </article>

        <article class="rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-slate-200">
            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-400">
                Evaluador
            </p>

            <p class="mt-1 text-sm font-black text-slate-950">
                {{ $evaluacion->evaluador->usuario->name }}
            </p>
        </article>
    </section>

    {{-- Instrucciones y escala --}}
    <section class="mt-4 grid gap-3 lg:grid-cols-[1.3fr_1fr]">
        <article class="rounded-xl border {{ $estilo['borde'] }} {{ $estilo['fondo'] }} px-4 py-3">
            <p class="text-[10px] font-black uppercase tracking-[0.18em] {{ $estilo['texto'] }}">
                Instrucciones
            </p>

            <p class="mt-1.5 text-sm leading-6 text-slate-700">
                Lea cuidadosamente cada criterio y seleccione la calificación
                que mejor represente el desempeño observado. Puede guardar un
                borrador y continuar posteriormente.
            </p>
        </article>

        <article class="rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-slate-200">
            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">
                Escala de evaluación
            </p>

            <div class="mt-2 grid gap-2 sm:grid-cols-4">
                <span class="rounded-lg bg-red-50 px-2 py-2 text-center text-xs font-bold text-red-700">
                    1 · Deficiente
                </span>

                <span class="rounded-lg bg-amber-50 px-2 py-2 text-center text-xs font-bold text-amber-700">
                    2 · Necesita mejora
                </span>

                <span class="rounded-lg bg-blue-50 px-2 py-2 text-center text-xs font-bold text-blue-700">
                    3 · Cumple
                </span>

                <span class="rounded-lg bg-emerald-50 px-2 py-2 text-center text-xs font-bold text-emerald-700">
                    4 · Sobresaliente
                </span>
            </div>
        </article>
    </section>

    {{-- Dimensiones y preguntas --}}
    <section class="mt-4 space-y-4">
        @foreach ($evaluacion->plantilla->dimensiones as $dimension)
            <article class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                {{-- Encabezado de la dimensión --}}
                <div class="flex flex-col gap-2 border-b border-slate-200 pb-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] {{ $estilo['texto'] }}">
                            {{ $numerosRomanos[$dimension->orden] ?? $dimension->orden }}. Dimensión
                        </p>

                        <h2 class="mt-1 text-lg font-black tracking-tight text-slate-950">
                            {{ $dimension->nombre }}
                        </h2>

                        @if ($dimension->factor)
                            <p class="mt-1 text-xs text-slate-500">
                                Factor: {{ $dimension->factor }}
                            </p>
                        @endif
                    </div>

                    <span class="w-fit rounded-full {{ $estilo['fondo'] }} px-3 py-1 text-[11px] font-bold {{ $estilo['texto'] }}">
                        {{ $dimension->preguntas->count() }}
                        {{ $dimension->preguntas->count() === 1 ? 'criterio' : 'criterios' }}
                    </span>
                </div>

                {{-- Preguntas --}}
                <div class="mt-3 space-y-2">
                    @foreach ($dimension->preguntas as $pregunta)
                        <div
                            wire:key="pregunta-{{ $pregunta->id }}"
                            class="grid gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 md:grid-cols-[1fr_210px] md:items-center"
                        >
                            <p class="text-sm font-semibold leading-5 text-slate-700">
                                {{ $pregunta->texto }}
                            </p>

                            <div class="grid grid-cols-4 gap-1.5">
                                @foreach ([1, 2, 3, 4] as $valor)
                                    <button
                                        type="button"
                                        wire:click="$set('respuestas.{{ $pregunta->id }}', {{ $valor }})"
                                        class="
                                            rounded-lg border px-2 py-1.5 text-xs font-black transition
                                            @if ((int) ($respuestas[$pregunta->id] ?? 0) === $valor)
                                                border-transparent {{ $estilo['boton'] }} text-white shadow-sm
                                            @else
                                                border-slate-300 bg-white text-slate-600 hover:border-slate-400 hover:bg-slate-100
                                            @endif
                                        "
                                    >
                                        {{ $valor }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        @endforeach
    </section>

    {{-- Observaciones y acciones --}}
    <section class="mt-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
        <div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] {{ $estilo['texto'] }}">
                Comentarios adicionales
            </p>

            <h2 class="mt-1 text-lg font-black text-slate-950">
                Observaciones del evaluador
            </h2>

            <p class="mt-1 text-xs leading-5 text-slate-500">
                Este campo es opcional. Puede escribir fortalezas,
                oportunidades de mejora o comentarios relevantes.
            </p>
        </div>

        <textarea
            wire:model="observaciones"
            rows="4"
            maxlength="2000"
            placeholder="Escriba sus observaciones aquí..."
            class="mt-3 w-full resize-none rounded-xl border border-slate-300 bg-slate-50 p-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
        ></textarea>

        @error('observaciones')
            <p class="mt-2 text-xs font-bold text-red-700">
                {{ $message }}
            </p>
        @enderror

        <div class="mt-4 flex flex-col gap-2 border-t border-slate-100 pt-3 sm:flex-row sm:justify-end">
            <a
                href="{{ route('dashboard') }}"
                class="rounded-lg border border-slate-300 px-4 py-2 text-center text-xs font-black text-slate-700 transition hover:bg-slate-50"
            >
                Cancelar
            </a>

            <button
                type="button"
                wire:click="guardarBorrador"
                wire:loading.attr="disabled"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-black text-slate-700 transition hover:bg-slate-50 disabled:cursor-wait disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="guardarBorrador">
                    Guardar borrador
                </span>

                <span wire:loading wire:target="guardarBorrador">
                    Guardando...
                </span>
            </button>

            <button
                type="button"
                wire:click="finalizarEvaluacion"
                wire:loading.attr="disabled"
                class="rounded-lg {{ $estilo['boton'] }} px-4 py-2 text-xs font-black text-white shadow-sm transition disabled:cursor-wait disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="finalizarEvaluacion">
                    Finalizar evaluación
                </span>

                <span wire:loading wire:target="finalizarEvaluacion">
                    Finalizando...
                </span>
            </button>
        </div>
    </section>
</div>