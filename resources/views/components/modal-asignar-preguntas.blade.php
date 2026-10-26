
@props([
    'plantillasDisponibles',
    'preguntasActivas',
    'preguntasSeleccionadas',
    'cantidadNormales',
    'cantidadPredeterminadas',
    'cantidadTotal',
])

<flux:modal wire:model="mostrarModalPreguntas" class="w-full max-w-6xl">

    <div class="flex h-[min(820px,calc(100dvh-90px))] min-h-0 flex-col gap-4">

        {{-- ENCABEZADO FIJO --}}
        <div class="shrink-0 border-b border-slate-200 pb-4">
            <flux:heading size="lg">
                Asignar preguntas a plantilla
            </flux:heading>

            <flux:subheading>
                Seleccione una plantilla y complete 10 preguntas.
                Las predeterminadas se incluyen automáticamente.
            </flux:subheading>
        </div>

        {{-- SELECTOR DE PLANTILLA --}}
        <div class="shrink-0 rounded-xl border border-slate-200 p-4">

            <flux:select wire:model="plantillaSeleccionadaId">
                <flux:select.option value="">
                    Seleccione una plantilla
                </flux:select.option>

                @foreach ($plantillasDisponibles as $plantilla)
                    <flux:select.option value="{{ $plantilla->id }}">
                        {{ $plantilla->nombre }} ({{ $plantilla->codigo }})
                    </flux:select.option>
                @endforeach
            </flux:select>

            @if ($plantillasDisponibles->isEmpty())
                <p class="mt-2 text-xs text-amber-700">
                    No hay plantillas pendientes de asignación.
                </p>
            @endif

            @error('plantillaSeleccionadaId')
                <p class="mt-2 text-xs font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>

        {{-- CONTADORES --}}
        <div class="grid shrink-0 grid-cols-3 gap-3">

            <div class="rounded-xl border border-blue-200 bg-blue-50 p-3">
                <p class="text-xs font-semibold text-blue-700">
                    Preguntas seleccionadas
                </p>
                <p class="mt-1 text-2xl font-black text-blue-950">
                    {{ $cantidadNormales }} / 8
                </p>
            </div>

            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3">
                <p class="text-xs font-semibold text-emerald-700">
                    Predeterminadas
                </p>
                <p class="mt-1 text-2xl font-black text-emerald-900">
                    {{ $cantidadPredeterminadas }} / 2
                </p>
            </div>

            <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-3">
                <p class="text-xs font-semibold text-indigo-700">
                    Total de preguntas
                </p>
                <p class="mt-1 text-2xl font-black text-indigo-950">
                    {{ $cantidadTotal }} / 10
                </p>
            </div>

        </div>

        {{-- ÚNICA ZONA CON SCROLL --}}
        <div class="min-h-0 flex-1 space-y-4 overflow-y-auto overscroll-contain pr-2">

            <flux:input
                wire:model.live.debounce.300ms="buscarPregunta"
                placeholder="Buscar pregunta..."
                icon="magnifying-glass"
                clearable
            />

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">

                @forelse ($preguntasActivas as $pregunta)
                    @php
                        $seleccionada = in_array(
                            $pregunta->id,
                            $preguntasSeleccionadas
                        );

                        $limiteAlcanzado = count($preguntasSeleccionadas) >= 10;

                        $deshabilitada = $pregunta->es_predeterminada ||
                            (!$seleccionada && $limiteAlcanzado);

                        $tipos = $pregunta->tiposRespuesta;
                    @endphp

                    <div
                        wire:key="pregunta-banco-{{ $pregunta->id }}"
                        class="rounded-xl border p-4 transition
                            {{ $seleccionada
                                ? 'border-blue-300 bg-blue-50/40'
                                : 'border-slate-200 bg-white' }}">

                        <div class="flex items-start gap-3">

                            {{-- CHECKBOX Y ÁREA SELECCIONABLE --}}
                            <label
                                for="pregunta-{{ $pregunta->id }}"
                                class="flex min-w-0 flex-1 cursor-pointer items-start gap-3">

                                <input
                                    id="pregunta-{{ $pregunta->id }}"
                                    type="checkbox"
                                    wire:model.live="preguntasSeleccionadas"
                                    value="{{ $pregunta->id }}"
                                    @disabled($deshabilitada)
                                    class="mt-1 h-4 w-4 shrink-0 rounded border-slate-300"
                                >

                                <div class="min-w-0 flex-1 space-y-3">

                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs font-bold text-slate-400">
                                            #{{ $pregunta->id }}
                                        </span>

                                        @if ($pregunta->es_predeterminada)
                                            <flux:badge size="sm" color="emerald">
                                                Predeterminada
                                            </flux:badge>
                                        @endif
                                    </div>

                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $pregunta->texto }}
                                    </p>

                                    <div class="flex flex-wrap gap-2">

                                        <flux:badge size="sm" color="blue">
                                            {{ $pregunta->factor?->nombre ?? 'Sin factor' }}
                                        </flux:badge>

                                        @if ($pregunta->tema)
                                            <flux:badge size="sm" color="zinc">
                                                {{ $pregunta->tema->nombre }}
                                            </flux:badge>
                                        @endif

                                    </div>

                                </div>

                            </label>

                        </div>

                        {{-- SELECTOR DE TIPO FUERA DEL LABEL --}}
                        @if ($seleccionada && $tipos->count() > 1)
                            <div class="mt-3 border-t border-slate-200 pt-3">

                                <flux:select
                                    wire:key="tipo-pregunta-{{ $pregunta->id }}"
                                    wire:model.live="tiposRespuestaSeleccionados.{{ $pregunta->id }}"
                                    label="Tipo de respuesta"
                                    placeholder="Seleccione un tipo">

                                    <flux:select.option value="">
                                        Seleccione un tipo
                                    </flux:select.option>

                                    @foreach ($tipos as $tipo)
                                        <flux:select.option value="{{ $tipo->id }}">
                                            {{ $tipo->nombre }}
                                        </flux:select.option>
                                    @endforeach

                                </flux:select>

                            </div>
                        @endif

                        @if ($seleccionada && $tipos->isEmpty())
                            <p class="mt-3 text-xs font-semibold text-red-600">
                                Esta pregunta no tiene tipos de respuesta configurados.
                            </p>
                        @endif

                    </div>

                @empty
                    <p class="col-span-full py-8 text-center text-sm text-slate-500">
                        No se encontraron preguntas activas.
                    </p>
                @endforelse

            </div>

        </div>

        {{-- ERRORES FUERA DEL SCROLL --}}
        @error('preguntasSeleccionadas')
            <p class="shrink-0 text-sm font-semibold text-red-600">
                {{ $message }}
            </p>
        @enderror

        @error('tiposRespuestaSeleccionados')
            <p class="shrink-0 text-sm font-semibold text-red-600">
                {{ $message }}
            </p>
        @enderror

        {{-- PIE FIJO --}}
        <div class="flex shrink-0 items-center justify-end gap-3 border-t border-slate-200 bg-white pt-4">

            <flux:button
                type="button"
                variant="subtle"
                wire:click="cerrarModalPreguntas">
                Cancelar
            </flux:button>

            <flux:button
                type="button"
                variant="primary"
                wire:click="guardarPreguntas"
                wire:loading.attr="disabled"
                wire:target="guardarPreguntas">

                <span wire:loading.remove wire:target="guardarPreguntas">
                    Guardar selección
                </span>

                <span wire:loading wire:target="guardarPreguntas">
                    Guardando...
                </span>

            </flux:button>

        </div>

    </div>

</flux:modal>
