<div class="mx-auto w-full max-w-[1600px] px-2 sm:px-4 lg:px-6 space-y-5">
    {{-- ENCABEZADO  --}}
    <div class="overflow-hidden rounded-2xl px-5 py-5 text-white shadow-lg sm:px-6"
        style="background: linear-gradient(110deg, #020617 0%, #172554 50%, #312e81 100%);">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex min-w-0 items-center gap-4">

                <img src="{{ asset('images/icono_muni.png') }}" alt="Municipalidad de Guatemala" width="75"
                    height="75" class="shrink-0 object-contain"
                    style="width:75px;height:75px;max-width:75px;max-height:75px;" />

                <div class="min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                        Administración
                    </p>

                    <h1 class="mt-1 text-xl font-black tracking-tight sm:text-2xl">
                        Plantillas de evaluación
                    </h1>

                    <p class="mt-1.5 text-xs leading-5 text-blue-100 sm:text-sm">
                        Cree y administre las plantillas de evaluación
                        para las encuestas de satisfacción.
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3">

                <flux:button type="button" wire:click="verPreguntas" variant="outline" icon="list-bullet"
                    class="font-bold"
                    style="background-color:#DBEAFE !important;
               color:#1E3A8A !important;
               border:1px solid #BFDBFE !important;">
                    Asignar preguntas
                </flux:button>

                <flux:button type="button" wire:click="crearPlantilla" variant="primary" icon="plus"
                    class="font-bold"
                    style="background-color:#FFFFFF !important;
               color:#1E3A8A !important;
               border:1px solid #FFFFFF !important;">
                    Nueva plantilla
                </flux:button>

            </div>

        </div>
    </div>

    {{-- MENSAJE --}}
    @if (session('mensaje'))
        <div x-data="{ mostrar: true }" x-show="mostrar" x-init="setTimeout(() => mostrar = false, 4000)"
            class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- CONTENIDO --}}
    <div class="space-y-5 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:p-6">

        {{-- TÍTULO Y BÚSQUEDA --}}
        <div class="flex flex-col gap-3 border-b border-slate-200 pb-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-700">
                    Formularios disponibles
                </p>

                <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                    Listado de plantillas
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Consulte y edite la información general de cada plantilla.
                </p>
            </div>

            <div class="w-full sm:w-80">
                <flux:input wire:model.live.debounce.300ms="buscar" label="Buscar plantilla"
                    placeholder="Código o nombre..." icon="magnifying-glass" clearable />
            </div>
        </div>

        {{-- TARJETAS DE RESUMEN --}}
        <div class="grid grid-cols-1 gap-3 md:grid-cols-3">

            {{-- TOTAL --}}
            <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-blue-700">
                            Total de plantillas
                        </p>
                        <p class="mt-2 text-3xl font-black text-blue-950">
                            {{ $totalPlantillas }}
                        </p>
                        <p class="mt-1 text-xs text-blue-700">
                            Plantillas registradas
                        </p>
                    </div>

                    <div class="rounded-xl bg-blue-100 p-3">
                        <flux:icon.document-text class="size-7 text-blue-700" />
                    </div>
                </div>
            </div>

            {{-- ACTIVAS --}}
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">
                            Plantillas activas
                        </p>
                        <p class="mt-2 text-3xl font-black text-emerald-900">
                            {{ $totalActivas }}
                        </p>
                        <p class="mt-1 text-xs text-emerald-700">
                            Actualmente habilitadas
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-100 p-3">
                        <flux:icon.check-circle class="size-7 text-emerald-700" />
                    </div>
                </div>
            </div>

            {{-- INACTIVAS --}}
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-red-700">
                            Plantillas inactivas
                        </p>
                        <p class="mt-2 text-3xl font-black text-red-900">
                            {{ $totalInactivas }}
                        </p>
                        <p class="mt-1 text-xs text-red-700">
                            Actualmente deshabilitadas
                        </p>
                    </div>

                    <div class="rounded-xl bg-red-100 p-3">
                        <flux:icon.x-circle class="size-7 text-red-700" />
                    </div>
                </div>
            </div>

        </div>

        {{-- TABLA DE PLANTILLAS --}}
        <flux:table :paginate="$plantillas">

            <flux:table.columns>
                <flux:table.column>Código</flux:table.column>
                <flux:table.column>Plantilla</flux:table.column>
                <flux:table.column class="text-center">Estado</flux:table.column>
                <flux:table.column class="text-end">Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($plantillas as $plantilla)
                    <flux:table.row wire:key="plantilla-{{ $plantilla->id }}">

                        <flux:table.cell>
                            <flux:badge variant="pill" color="blue" size="sm">
                                {{ $plantilla->codigo }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <p class="text-sm font-bold text-slate-900">
                                {{ $plantilla->nombre }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ $plantilla->descripcion ?: 'Sin descripción registrada.' }}
                            </p>
                        </flux:table.cell>

                        <flux:table.cell class="text-center">
                            <flux:badge variant="pill" :color="$plantilla->activo ? 'emerald' : 'red'" size="sm">
                                {{ $plantilla->activo ? 'Activa' : 'Inactiva' }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell class="text-end">
                            <div class="flex flex-wrap items-center justify-end gap-2">

                                {{-- EDITAR --}}
                                <flux:button type="button" size="sm" variant="subtle" icon="pencil-square"
                                    wire:click="editar({{ $plantilla->id }})">
                                    Editar
                                </flux:button>

                                <flux:button type="button" size="sm" variant="primary" icon="list-bullet"
                                    wire:click="verPreguntasAsignadas({{ $plantilla->id }})">
                                    Ver preguntas
                                </flux:button>

                                {{-- ACTIVAR / DESACTIVAR --}}
                                <flux:button type="button" size="sm"
                                    :variant="$plantilla->activo ? 'danger' : 'primary'"
                                    :icon="$plantilla->activo ? 'x-circle' : 'check-circle'"
                                    wire:click="confirmarCambioEstado({{ $plantilla->id }})"
                                    style="width: 135px !important;
                                    min-width: 135px !important;
                                    max-width: 135px !important;
                                    display: inline-flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    box-sizing: border-box !important;">

                                    {{ $plantilla->activo ? 'Desactivar' : 'Activar' }}

                                </flux:button>

                            </div>
                        </flux:table.cell>

                    </flux:table.row>

                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="py-10 text-center">
                            <p class="font-semibold text-slate-700">
                                No se encontraron plantillas.
                            </p>
                            <p class="mt-1 text-xs text-slate-500">
                                Pruebe otra búsqueda o registre una nueva plantilla.
                            </p>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>

        </flux:table>

    </div>

    {{-- MODAL CREAR / EDITAR --}}
    <flux:modal wire:model="mostrarModalPlantilla" class="max-w-lg space-y-6">

        <div>
            <flux:heading size="lg">
                {{ $plantillaId ? 'Editar plantilla' : 'Nueva plantilla' }}
            </flux:heading>

            <flux:subheading>
                Complete los datos generales de la plantilla de evaluación.
            </flux:subheading>
        </div>

        <form wire:submit="guardarPlantilla" class="space-y-4">

            <flux:input wire:model="codigoPlantilla" label="Código" placeholder="Ej. CURSO-01" maxlength="10" />

            @error('codigoPlantilla')
                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
            @enderror

            <flux:input wire:model="nombrePlantilla" label="Nombre" placeholder="Nombre de la plantilla" />

            @error('nombrePlantilla')
                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
            @enderror

            <flux:textarea wire:model="descripcionPlantilla" label="Descripción" rows="3"
                placeholder="Descripción de la plantilla..." />

            @error('descripcionPlantilla')
                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
            @enderror

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">

                <flux:button type="button" variant="subtle" wire:click="cerrarModalPlantilla">
                    Cancelar
                </flux:button>

                <flux:button type="submit" variant="primary" wire:loading.attr="disabled"
                    wire:target="guardarPlantilla">

                    <span wire:loading.remove wire:target="guardarPlantilla">
                        Guardar
                    </span>

                    <span wire:loading wire:target="guardarPlantilla">
                        Guardando...
                    </span>

                </flux:button>

            </div>
        </form>

    </flux:modal>
    {{-- MODAL: ASIGNAR PREGUNTAS --}}
    <flux:modal wire:model="mostrarModalPreguntas" class="w-full max-w-6xl !overflow-hidden">

        <div class="flex min-h-0 flex-col gap-4 overflow-hidden" style="height: min(820px, calc(100dvh - 90px));">

            {{-- ENCABEZADO --}}
            <div class="shrink-0 border-b border-slate-200 pb-4">
                <flux:heading size="lg">
                    Asignar preguntas a plantilla
                </flux:heading>

                <flux:subheading>
                    Seleccione una plantilla y complete 10 preguntas.
                    Las predeterminadas se incluyen automáticamente.
                </flux:subheading>
            </div>

            {{-- PLANTILLA --}}
            <div class="shrink-0 rounded-xl border border-slate-200 p-4">

                <flux:select wire:model="plantillaSeleccionadaId">
                    <flux:select.option value="">
                        Seleccione una plantilla
                    </flux:select.option>

                    @foreach ($plantillasDisponibles as $plantilla)
                        <flux:select.option value="{{ $plantilla->id }}">
                            {{ $plantilla->nombre }}
                            ({{ $plantilla->codigo }})
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

            {{-- CONTADORES: 8 normales + 2 predeterminadas = 10 --}}
            <div class="flex w-full shrink-0 flex-row gap-3">

                {{-- PREGUNTAS NORMALES --}}
                <div class="min-w-0 flex-1 rounded-xl border border-blue-200 bg-blue-50 p-4">
                    <p class="text-xs font-semibold text-blue-700">
                        Preguntas seleccionadas
                    </p>

                    <p class="mt-1 text-2xl font-black text-blue-950">
                        {{ $cantidadNormales }} / 8
                    </p>
                </div>

                {{-- PREDETERMINADAS --}}
                <div class="min-w-0 flex-1 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                    <p class="text-xs font-semibold text-emerald-700">
                        Preguntas predeterminadas
                    </p>

                    <p class="mt-1 text-2xl font-black text-emerald-900">
                        {{ $cantidadPredeterminadas }} / 2
                    </p>
                </div>

                {{-- TOTAL --}}
                <div class="min-w-0 flex-1 rounded-xl border border-indigo-200 bg-indigo-50 p-4">
                    <p class="text-xs font-semibold text-indigo-700">
                        Total de preguntas
                    </p>

                    <p class="mt-1 text-2xl font-black text-indigo-950">
                        {{ $cantidadTotal }} / 10
                    </p>
                </div>

            </div>

            {{-- CONTENIDO DESPLAZABLE: solo el buscador y las tarjetas hacen scroll --}}
            <div class="min-h-0 flex-1 space-y-5 overflow-y-auto pr-2">

                {{-- BUSCADOR --}}
                <flux:input wire:model.live.debounce.300ms="buscarPregunta" placeholder="Buscar pregunta..."
                    icon="magnifying-glass" clearable />

                {{-- BANCO DE PREGUNTAS --}}
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">

                    @forelse ($preguntasActivas as $pregunta)
                        @php
                            $seleccionada = in_array($pregunta->id, $preguntasSeleccionadas);

                            $limiteAlcanzado = count($preguntasSeleccionadas) >= 10;

                            $tipos = $pregunta->tiposRespuesta;
                        @endphp

                        <div wire:key="pregunta-banco-{{ $pregunta->id }}"
                            class="relative rounded-xl border transition
                            {{ $seleccionada ? 'border-blue-300 bg-blue-50/40' : 'border-slate-200 bg-white' }}">

                            {{-- ÁREA SELECCIONABLE: el label ocupa toda la zona informativa --}}
                            <label for="pregunta-{{ $pregunta->id }}"
                                class="flex w-full cursor-pointer items-start gap-3 p-4
                                {{ $pregunta->es_predeterminada || (!$seleccionada && $limiteAlcanzado)
                                    ? 'cursor-default'
                                    : 'hover:bg-blue-50/50' }}">

                                {{-- CHECKBOX --}}
                                <input id="pregunta-{{ $pregunta->id }}" type="checkbox"
                                    wire:model.live="preguntasSeleccionadas" value="{{ $pregunta->id }}"
                                    @disabled($pregunta->es_predeterminada || (!$seleccionada && $limiteAlcanzado))
                                    class="mt-1 h-4 w-4 shrink-0 rounded border-slate-300">

                                {{-- INFORMACIÓN --}}
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

                                    {{-- FACTOR Y TEMA DE LA PREGUNTA --}}
                                    <div class="flex flex-wrap gap-2">

                                        <flux:badge size="sm" color="blue">
                                            <span class="font-bold">Factor:</span>
                                            {{ $pregunta->factor?->nombre ?? 'Sin factor' }}
                                        </flux:badge>

                                        <flux:badge size="sm" color="zinc">
                                            <span class="font-bold">Tema:</span>
                                            {{ $pregunta->tema?->nombre ?? 'Sin tema' }}
                                        </flux:badge>

                                        <flux:badge color="amber" size="sm">
                                            Tipos respuesta:
                                            {{ $pregunta->tiposRespuesta->pluck('nombre')->implode(', ') ?: 'Sin tipo respuesta' }}
                                        </flux:badge>


                                    </div>

                                </div>

                            </label>

                            {{-- TIPO DE RESPUESTA --}}
                            {{-- Se muestra siempre que existan varias opciones --}}
                            @if ($tipos->count() > 1)
                                <div class="border-t border-slate-200 px-4 py-3">

                                    <flux:select wire:key="tipo-pregunta-{{ $pregunta->id }}"
                                        wire:model.live="tiposRespuestaSeleccionados.{{ $pregunta->id }}"
                                        label="Tipo de respuesta" :disabled="!$seleccionada">

                                        <flux:select.option value="">
                                            Seleccione un tipo
                                        </flux:select.option>

                                        @foreach ($tipos as $tipo)
                                            <flux:select.option value="{{ $tipo->id }}">
                                                {{ $tipo->nombre }}
                                            </flux:select.option>
                                        @endforeach

                                    </flux:select>

                                    @if (!$seleccionada)
                                        <p class="mt-1 text-xs text-slate-500">
                                            Seleccione esta pregunta para elegir el tipo de respuesta.
                                        </p>
                                    @endif

                                </div>
                            @endif

                            @if ($seleccionada && $tipos->isEmpty())
                                <p class="px-4 pb-3 text-xs font-semibold text-red-600">
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

            </div> {{-- FIN DEL ÁREA DESPLAZABLE --}}

            {{-- ERRORES --}}
            @error('preguntasSeleccionadas')
                <p class="text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror

            @error('tiposRespuestaSeleccionados')
                <p class="text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror

            {{-- PIE FIJO: siempre visible, fuera del contenedor con scroll --}}
            <div class="flex shrink-0 items-center justify-end gap-3 border-t border-slate-200 bg-white pt-4">

                <flux:button type="button" variant="subtle" wire:click="cerrarModalPreguntas">
                    Cancelar
                </flux:button>

                <flux:button type="button" variant="primary" wire:click="guardarPreguntas"
                    wire:loading.attr="disabled" wire:target="guardarPreguntas">

                    <span wire:loading.remove wire:target="guardarPreguntas">
                        Guardar selección
                    </span>

                    <span wire:loading wire:target="guardarPreguntas">
                        Guardando...
                    </span>

                </flux:button>

            </div>

        </div> {{-- FIN DEL CONTENEDOR FLEX DEL MODAL --}}

    </flux:modal>

    <flux:modal wire:model="mostrarModalPreguntasAsignadas" class="w-full max-w-5xl !overflow-hidden">
        <div class="flex min-h-0 flex-col gap-4 overflow-hidden" style="height: min(760px, calc(100dvh - 100px));">
            <div class="shrink-0 border-b border-slate-200 pb-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/icono_muni.png') }}" alt="Municipalidad de Guatemala"
                        class="h-14 w-14 shrink-0 object-contain" />
                    <div class="min-w-0 flex-1">
                        <flux:heading size="lg">
                            Preguntas de la plantilla
                        </flux:heading>
                        @if ($plantillaConsulta)
                            <flux:subheading class="mt-1">
                                {{ $plantillaConsulta->nombre }}
                                ({{ $plantillaConsulta->codigo }})
                            </flux:subheading>
                        @endif
                    </div>
                </div>
            </div>
            @if ($plantillaConsulta)
                <div class="grid shrink-0 grid-cols-1 gap-3 sm:grid-cols-2">
                    <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
                        <p class="text-xs font-semibold text-blue-700">
                            Preguntas asignadas
                        </p>
                        <p class="mt-1 text-2xl font-black text-blue-950">
                            {{ $plantillaConsulta->preguntas->count() }} / 10
                        </p>
                    </div>
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                        <p class="text-xs font-semibold text-emerald-700">
                            Preguntas predeterminadas
                        </p>
                        <p class="mt-1 text-2xl font-black text-emerald-900">
                            {{ $plantillaConsulta->preguntas->where('es_predeterminada', true)->count() }}
                            / 2
                        </p>
                    </div>
                </div>
                {{--  TITULO DEL LISTADO --}}
                <div class="flex shrink-0 items-center justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">
                            Preguntas del formulario
                        </h3>
                        <p class="mt-1 text-xs text-slate-500">
                            Preguntas organizadas según su orden de resentación
                        </p>
                    </div>
                    <flux:badge color="zinc" size="sm">
                        {{ $plantillaConsulta->preguntas->count() }} preguntas
                    </flux:badge>
                </div>
                {{-- LISTADO DESPLAZABLE --}}
                <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain pr-2">
                    @if (count($ordenPreguntas) > 0)

                        @foreach ($ordenPreguntas as $indice => $preguntaId)
                            @php
                                $pregunta = $plantillaConsulta->preguntas->firstWhere('id', $preguntaId);
                            @endphp

                            @if (!$pregunta)
                                @continue
                            @endif

                            <div wire:key="consulta-{{ $plantillaConsulta->id }}-{{ $pregunta->id }}"
                                class="mb-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                <div class="flex items-start gap-4">

                                    <div class="shrink-0 self-start">
                                        <x-numero-orden :numero="$indice + 1" />
                                    </div>

                                    <div class="min-w-0 flex-1">

                                        <div class="flex flex-wrap items-center justify-between gap-2">

                                            <span
                                                class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                                Pregunta {{ $indice + 1 }}
                                            </span>

                                            <flux:badge size="sm"
                                                :color="$pregunta->es_predeterminada ? 'emerald' : 'zinc'">
                                                {{ $pregunta->es_predeterminada ? 'Predeterminada' : 'General' }}
                                            </flux:badge>

                                        </div>

                                        <p class="mt-2 text-sm font-semibold leading-6 text-slate-900">
                                            {{ $pregunta->texto }}
                                        </p>

                                        <div
                                            class="mt-3 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-3">

                                            <flux:badge color="blue" size="sm">
                                                Factor:
                                                {{ $pregunta->factor?->nombre ?? 'Sin factor' }}
                                            </flux:badge>

                                            <flux:badge color="zinc" size="sm">
                                                Tema:
                                                {{ $pregunta->tema?->nombre ?? 'Sin tema' }}
                                            </flux:badge>

                                            <flux:badge color="amber" size="sm">
                                                Tipos respuesta:
                                                {{ $pregunta->tiposRespuesta->pluck('nombre')->implode(', ') ?: 'Sin tipo respuesta' }}
                                            </flux:badge>

                                        </div>

                                    </div>

                                    <div class="flex shrink-0 flex-col items-center gap-2">

                                        <flux:button type="button" size="sm" variant="outline"
                                            icon="chevron-up"
                                            wire:click="moverPregunta({{ $indice }}, 'arriba')"
                                            :disabled="$indice === 0" title="Subir pregunta" />

                                        <flux:button type="button" size="sm" variant="outline"
                                            icon="chevron-down"
                                            wire:click="moverPregunta({{ $indice }}, 'abajo')"
                                            :disabled="$indice === count($ordenPreguntas) - 1"
                                            title="Bajar pregunta" />

                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @else
                        <div
                            class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                            <p class="text-sm font-semibold text-slate-700">
                                Esta plantilla todavía no tiene preguntas asignadas.
                            </p>
                        </div>

                    @endif
                </div>
            @endif
            {{-- pie fijo --}}
            <div class="flex justify-end gap-3">

                <flux:button type="button" variant="subtle" wire:click="cerrarPreguntasAsignadas">
                    Cancelar
                </flux:button>

                <flux:button type="button" variant="primary" wire:click="guardarOrdenPreguntas"
                    wire:loading.attr="disabled" wire:target="guardarOrdenPreguntas">
                    Guardar orden
                </flux:button>

            </div>

            @error('ordenPreguntas')
                <p class="text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>
    </flux:modal>

    {{-- CONFIRMACIÓN DE CAMBIO DE ESTADO --}}
    <x-confirmacion nombre="confirmar-estado-plantilla" :titulo="$nuevoEstadoPlantilla ? 'Activar plantilla' : 'Desactivar plantilla'" :mensaje="$nuevoEstadoPlantilla
        ? '¿Está seguro de que desea activar la plantilla ' . $nombrePlantillaEstado . '?'
        : '¿Está seguro de que desea desactivar la plantilla ' . $nombrePlantillaEstado . '?'" :texto-confirmar="$nuevoEstadoPlantilla ? 'Sí, activar' : 'Sí, desactivar'"
        :color="$nuevoEstadoPlantilla ? 'primary' : 'danger'" accion="cambiarEstadoPlantilla">
    </x-confirmacion>
</div>
