<div class="mx-auto w-full max-w-[1600px] px-2 sm:px-4 lg:px-6 space-y-4">

    <div
        class="overflow-hidden rounded-2xl bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-6 py-5 text-white shadow-lg">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <!-- Logo y encabezado -->
            <div class="flex min-w-0 items-center gap-4">

                <!-- Logo municipal -->
                <div class="flex h-20 w-20 shrink-0 items-center justify-center">
                    <img src="{{ asset('images/icono_muni.png') }}" alt="Municipalidad de Guatemala" width="75"
                        height="75"
                        style="width: 75px !important;
                           height: 75px !important;
                           max-width: 75px !important;
                           max-height: 75px !important;
                           object-fit: contain;
                           flex-shrink: 0;" />
                </div>

                <!-- Textos -->
                <div class="min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                        Asistente
                    </p>

                    <h1 class="mt-1 text-2xl font-black tracking-tight">
                        Preguntas
                    </h1>

                    <p class="mt-1 max-w-3xl text-sm leading-5 text-blue-100">
                        Gestione las preguntas de evaluación agrupadas por factores y temas.
                    </p>
                </div>
            </div>

            <!-- Botón -->
            <flux:button wire:click="crear" variant="primary"
                class="w-fit shrink-0 bg-white text-xs font-black text-blue-900 hover:bg-blue-50">
                + Nueva pregunta
            </flux:button>

        </div>
    </div>


    {{--  mensaje --}}
    @if (session('mensaje'))
        <div x-data="{ mostrar: true }" x-show="mostrar" x-init="setTimeout(() => mostrar = false, 4000)"
            class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800">
            {{ session('mensaje') }}
        </div>
    @endif
    @error('es_predeterminada')
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">
            {{ $message }}
        </div>
    @enderror
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 space-y-4">
        <!-- encabezado tabla-->

        {{-- Encabezado del listado --}}
        <div class="space-y-5 border-b border-slate-200 pb-5">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-700">
                        Banco de reactivos
                    </p>

                    <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                        Listado de preguntas
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Busque y filtre las preguntas registradas en el sistema.
                    </p>
                </div>

                <flux:badge color="blue" size="sm">
                    {{ $preguntas->total() }} preguntas
                </flux:badge>
            </div>

            {{-- Resumen de preguntas predeterminadas activas --}}
            {{-- Resumen general de preguntas --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                {{-- Preguntas activas --}}
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">
                                Preguntas activas
                            </p>

                            <p class="mt-2 text-3xl font-black text-emerald-800">
                                {{ $totalActivas }}
                            </p>

                            <p class="mt-1 text-xs text-emerald-700">
                                Disponibles para utilizar en encuestas
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-100">
                            <flux:icon.check-circle class="size-7 text-emerald-700" />
                        </div>

                    </div>
                </div>

                {{-- Preguntas inactivas --}}
                <div class="rounded-xl border border-red-200 bg-red-50 p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-red-700">
                                Preguntas inactivas
                            </p>

                            <p class="mt-2 text-3xl font-black text-red-800">
                                {{ $totalInactivas }}
                            </p>

                            <p class="mt-1 text-xs text-red-700">
                                No disponibles para nuevas encuestas
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-100">
                            <flux:icon.x-circle class="size-7 text-red-700" />
                        </div>

                    </div>
                </div>

                {{-- Preguntas predeterminadas --}}
                <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-blue-700">
                                Preguntas predeterminadas
                            </p>

                            <p class="mt-2 text-3xl font-black text-blue-900">
                                {{ $totalPredeterminadas }}
                                <span class="text-base font-semibold text-blue-500">
                                    / 2
                                </span>
                            </p>

                            <p class="mt-1 text-xs text-blue-700">
                                {{ 10 - $totalPredeterminadas }} espacios disponibles por plantilla
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-100">
                            <flux:icon.clipboard-document-list class="size-7 text-blue-700" />
                        </div>

                    </div>
                </div>

            </div>

            {{-- Buscador principal --}}
            <div class="space-y-2">
                <flux:input wire:model.live.debounce.400ms="buscar" label="Buscar preguntas"
                    placeholder="Buscar por código o texto de la pregunta..." icon="magnifying-glass" size="lg"
                    clearable class="w-full" />
            </div>

            {{-- Panel de filtros --}}
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <flux:icon.funnel class="size-4 text-blue-700" />

                        <h3 class="text-sm font-bold text-slate-800">
                            Filtrar preguntas
                        </h3>
                    </div>

                    <flux:button type="button" size="sm" variant="subtle" icon="x-mark"
                        wire:click="limpiarFiltros">
                        Limpiar filtros
                    </flux:button>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2"
                    style="grid-template-columns: repeat(5, minmax(0, 1fr));">
                    <flux:select wire:model.live="filtroFactor" label="Factor">
                        <option value="">Todos los factores</option>

                        @foreach ($factores as $factor)
                            <option value="{{ $factor->id }}">
                                {{ $factor->nombre }}
                            </option>
                        @endforeach
                    </flux:select>

                    {{-- Tema / Aspecto --}}
                    <flux:select wire:model.live="filtroTema" label="Tema / Aspecto">
                        <option value="">Todos los temas</option>

                        @foreach ($temas as $tema)
                            <option value="{{ $tema->id }}">
                                {{ $tema->nombre }}
                            </option>
                        @endforeach
                    </flux:select>

                    {{-- Tipo de respuesta --}}
                    <flux:select wire:model.live="filtroTipo" label="Tipo de respuesta">
                        <option value="">Todos los tipos</option>

                        @foreach ($tiposRespuesta as $tipo)
                            <option value="{{ $tipo->id }}">
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </flux:select>

                    {{-- Filtro NPS --}}
                    <flux:select wire:model.live="filtroNps" label="Clasificación NPS">
                        <option value="todos">Todas las preguntas</option>
                        <option value="nps">Solo NPS</option>
                        <option value="no-nps">No NPS</option>
                    </flux:select>
                    {{-- Filtro de preguntas predeterminadas --}}
                    <flux:select wire:model.live="filtroPredeterminada" label="Pregunta predeterminada">
                        <option value="todos">Todas las preguntas</option>
                        <option value="predeterminadas">Solo predeterminadas</option>
                        <option value="no-predeterminadas">No predeterminadas</option>
                    </flux:select>
                </div>
            </div>

        </div>


        <flux:table :paginate="$preguntas">
            <flux:table.columns>
                <flux:table.column class="text-center">
                    ID
                </flux:table.column>
                <flux:table.column>
                    Pregunta
                </flux:table.column>
                <flux:table.column>
                    Factor
                </flux:table.column>
                <flux:table.column>
                    Tema / Aspecto
                </flux:table.column>
                <flux:table.column>
                    Tipo
                </flux:table.column>
                <flux:table.column class="text-center">
                    Estado
                </flux:table.column>
                <flux:table.column class="text-end">
                    Acciones
                </flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse($preguntas as $pregunta)
                    <flux:table.row wire:key="pregunta-{{ $pregunta->id }}">
                        <flux:table.cell class="text-center">
                            <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-black text-slate-700">
                                #{{ $pregunta->id }}
                            </span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex items-center gap-2">
                                <span
                                    class="shrink-0 rounded bg-blue-50 px-2 py-1 text-[10px] font-bold text-blue-700">{{ $pregunta->codigo }}</span>
                                <p class="text-sm font-bold text-slate-900">
                                    {{ $pregunta->texto }}
                                </p>
                                @if ($pregunta->es_nps)
                                    <flux:badge variant="pill" color="violet" size="sm">
                                        NPS
                                    </flux:badge>
                                @endif
                                @if ($pregunta->es_predeterminada)
                                    <flux:badge variant="pill" color="blue" size="sm">Predeterminada
                                    </flux:badge>
                                @endif
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-xs font-semibold text-blue-700">
                                {{ $pregunta->factor?->nombre ?? 'Sin factor' }}
                            </span>
                        </flux:table.cell>
                        <!-- ?-> evita intentar leer nombre cuando la relación es null -->
                        <flux:table.cell>
                            @if ($pregunta->tema)
                                <span class="text-xs font-semibold text-slate-700">
                                    {{ $pregunta->tema->nombre }}
                                </span>
                            @else
                                <span class="text-xs italic text-slate-400">
                                    Sin tema o aspecto
                                </span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge variant="pill" size="sm">
                                {{ $pregunta->tiposRespuesta->pluck('nombre')->join(', ') ?: 'Sin tipo' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="text-center">
                            @if ($pregunta->activo)
                                <flux:badge variant="pill" color="green" size="sm">
                                    Activa
                                </flux:badge>
                            @else
                                <flux:badge variant="pill" color="red" size="sm">
                                    Inactiva
                                </flux:badge>
                            @endif
                        </flux:table.cell>
                        <!-- wire click le indica  a livewire que ejecute el metodo editar al hacer click -->
                        <flux:table.cell class="text-end">
                            <flux:button size="sm" variant="subtle" wire:click="editar({{ $pregunta->id }})">
                                Editar
                            </flux:button>
                            <flux:button size="sm" variant="subtle"
                                wire:click="cambiarEstado({{ $pregunta->id }})">
                                Cambiar estado
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="7" class="py-8 text-center">
                            <p class="text-sm font-black text-slate-700">
                                No se encontraron preguntas
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Cambie el texto de búsqueda o registre una nueva pregunta.
                            </p>

                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>
    <flux:modal wire:model="mostrarModal" class="max-w-3xl space-y-6">
        <div>
            <flux:heading size="lg">{{ $preguntaId ? 'Editar pregunta' : 'Nueva pregunta' }}</flux:heading>
            <flux:subheading>Banco de reactivos</flux:subheading>
        </div>

        <form wire:submit="guardar" class="space-y-4">
            <flux:input wire:model="codigo" label="Código de pregunta" placeholder="Ej. ATN-09" />
            @error('codigo')
                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
            @enderror

            <div class="rounded-xl border border-slate-200 p-3">
                <p class="mb-2 text-sm font-semibold text-slate-800">¿La pregunta es obligatoria?</p>
                <div class="flex gap-5">
                    <label class="flex items-center gap-2 text-sm"><input type="radio" wire:model="obligatoria"
                            value="1" class="accent-blue-700"> Sí</label>
                    <label class="flex items-center gap-2 text-sm"><input type="radio" wire:model="obligatoria"
                            value="0" class="accent-blue-700"> No</label>
                </div>
                @error('obligatoria')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Solo se puede configurar en preguntas existentes y activas.
                 predeterminadaOriginal mantiene visible el control hasta guardar. --}}
            @if ($preguntaId && $activo && ($predeterminadaOriginal || $totalPredeterminadas < 2))
                <div class="rounded-xl border border-blue-200 bg-blue-50/50 p-4 space-y-3">
                    <p class="text-sm font-bold text-slate-900">
                        ¿Desea que esta pregunta aparezca en todas las plantillas?
                    </p>
                    <p class="text-xs text-slate-600">
                        Se permiten como máximo 2 preguntas predeterminadas activas.
                        Una pregunta predeterminada es obligatoria.
                    </p>
                    <flux:checkbox wire:key="predeterminada-{{ $preguntaId }}" wire:model.live="es_predeterminada"
                        label="Marcar como pregunta predeterminada" />
                    @if ($predeterminadaOriginal && !$es_predeterminada)
                        <p class="text-xs font-semibold text-amber-700">
                            Al guardar, esta pregunta dejará de ser predeterminada.
                        </p>
                    @endif
                    @error('es_predeterminada')
                        <p class="text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <flux:select wire:model.live="factorId" label="Factor">
                <option value="">Seleccione un factor</option>
                @foreach ($factores as $factor)
                    <option value="{{ $factor->id }}">{{ $factor->nombre }}</option>
                @endforeach
            </flux:select>
            @error('factorId')
                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
            @enderror

            <flux:select wire:model="temaId" label="Tema" :disabled="!$factorId">
                <option value="">Seleccione un tema</option>
                @foreach ($temas as $tema)
                    <option value="{{ $tema->id }}">{{ $tema->nombre }}</option>
                @endforeach
            </flux:select>
            @error('temaId')
                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
            @enderror

            <flux:textarea wire:model="texto" label="Texto de la pregunta" rows="3"
                placeholder="Escriba la pregunta aquí..." :disabled="!$factorId" />
            @error('texto')
                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
            @enderror

            {{-- Única incorporación a la interfaz original: varios tipos por pregunta --}}
            <div class="rounded-xl border border-slate-200 p-4 space-y-3">
                <flux:checkbox wire:model.live="variosTipos"
                    label="¿Desea agregar varios tipos de respuesta a esta pregunta?" />
                <p class="text-xs text-slate-500">Cada tipo tiene su propia escala u opciones.</p>
                @if ($variosTipos)
                    <flux:button type="button" size="sm" variant="primary" wire:click="agregarTipo">
                        + Agregar otro tipo de respuesta
                    </flux:button>
                @endif
                @error('configuraciones')
                    <p class="text-xs font-bold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @foreach ($configuraciones as $clave => $config)
                <div wire:key="configuracion-{{ $clave }}"
                    class="space-y-3 rounded-xl border border-slate-200 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-bold text-slate-900">Tipo de respuesta {{ $loop->iteration }}</p>
                        @if (count($configuraciones) > 1)
                            <flux:button type="button" variant="danger" size="sm"
                                wire:click="eliminarTipo({{ $clave }})">Quitar tipo</flux:button>
                        @endif
                    </div>

                    <flux:select wire:model.live="configuraciones.{{ $clave }}.tipo_respuesta_id"
                        label="Tipo de respuesta" :disabled="!$factorId">
                        <option value="">Seleccione un tipo de respuesta</option>
                        @foreach ($tiposRespuesta as $tipoRespuesta)
                            <option value="{{ $tipoRespuesta->id }}">{{ $tipoRespuesta->nombre }}</option>
                        @endforeach
                    </flux:select>
                    @error('configuraciones.' . $clave . '.tipo_respuesta_id')
                        <p class="text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror

                    @if ($this->esEscala($clave))
                        <div class="space-y-3 rounded-xl border border-blue-200 bg-blue-50/50 p-4">
                            <flux:select wire:model.live="configuraciones.{{ $clave }}.escala_id"
                                label="Escala disponible">
                                <option value="">Seleccione una escala</option>
                                @foreach ($escalas as $escala)
                                    <option value="{{ $escala->id }}">{{ $escala->nombre }}</option>
                                @endforeach
                            </flux:select>
                            @error('configuraciones.' . $clave . '.escala_id')
                                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
                            @enderror
                            @php $escalaVista = $escalas->firstWhere('id', (int) ($config['escala_id'] ?? 0)); @endphp
                            @if ($escalaVista)
                                <div class="rounded-xl border border-slate-200 bg-white p-3 space-y-2">
                                    <p class="text-xs font-bold text-slate-700">Vista previa de la escala</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach (range($escalaVista->minimo, $escalaVista->maximo) as $numero)
                                            <span
                                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-xs font-semibold text-blue-800">{{ $numero }}</span>
                                        @endforeach
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @if ($escalaVista->permite_no_sabe)
                                            <span class="rounded-lg border border-slate-200 px-3 py-1 text-xs">No
                                                sabe</span>
                                        @endif
                                        @if ($escalaVista->permite_no_aplica)
                                            <span class="rounded-lg border border-slate-200 px-3 py-1 text-xs">No
                                                aplica</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @elseif ($this->esSeleccion($clave))
                        <div class="space-y-3 rounded-xl border border-slate-200 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Opciones de respuesta</p>
                                    <p class="text-xs text-slate-500">Agregue al menos dos opciones. El valor es el
                                        código interno.</p>
                                </div>
                                <flux:button type="button" size="sm" variant="primary"
                                    wire:click="agregarOpcion({{ $clave }})">+ Agregar</flux:button>
                            </div>
                            @error('configuraciones.' . $clave . '.opciones')
                                <p class="text-xs font-bold text-red-600">{{ $message }}</p>
                            @enderror
                            @foreach ($config['opciones'] as $indice => $opcion)
                                <div wire:key="opcion-{{ $clave }}-{{ $indice }}"
                                    class="grid grid-cols-1 gap-2 rounded-lg bg-slate-50 p-3 sm:grid-cols-[1fr_1.5fr_auto] sm:items-start">
                                    <div>
                                        <flux:input
                                            wire:model="configuraciones.{{ $clave }}.opciones.{{ $indice }}.valor"
                                            label="Valor" placeholder="ej. si" />
                                        @error('configuraciones.' . $clave . '.opciones.' . $indice . '.valor')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <flux:input
                                            wire:model="configuraciones.{{ $clave }}.opciones.{{ $indice }}.etiqueta"
                                            label="Etiqueta" placeholder="ej. Sí" />
                                        @error('configuraciones.' . $clave . '.opciones.' . $indice . '.etiqueta')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="sm:pt-6">
                                        <flux:button type="button" variant="danger" size="sm"
                                            wire:click="eliminarOpcion({{ $clave }}, {{ $indice }})">
                                            Quitar</flux:button>
                                    </div>
                                    <div class="sm:col-span-3 flex flex-wrap gap-5 border-t border-slate-200 pt-3">
                                        <flux:checkbox
                                            wire:model="configuraciones.{{ $clave }}.opciones.{{ $indice }}.es_excluyente"
                                            label="Es excluyente" />
                                        <flux:checkbox
                                            wire:model.live="configuraciones.{{ $clave }}.opciones.{{ $indice }}.habilita_texto"
                                            label="Habilita texto" />
                                    </div>
                                    @if ($opcion['habilita_texto'] ?? false)
                                        <div class="sm:col-span-3">
                                            <flux:input
                                                wire:model="configuraciones.{{ $clave }}.opciones.{{ $indice }}.etiqueta_texto_adicional"
                                                label="Etiqueta del texto adicional"
                                                placeholder="Ej. ¿En qué red social se enteró?" />
                                            @error('configuraciones.' . $clave . '.opciones.' . $indice .
                                                '.etiqueta_texto_adicional')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            @if (collect($configuraciones)->keys()->contains(fn($clave) => $this->esEscala((int) $clave)))
                <flux:checkbox wire:model="es_nps" label="Calcular NPS"
                    description="Marcar si esta pregunta es de tipo Net Promoter Score." :disabled="!$factorId" />
                @error('es_nps')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            @endif

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                <flux:button type="button" variant="subtle" wire:click="cerrarModal">Cancelar</flux:button>
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled" :disabled="!$factorId">
                    <span wire:loading.remove wire:target="guardar">Guardar cambios</span>
                    <span wire:loading wire:target="guardar">Guardando...</span>
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
