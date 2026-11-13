<div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-6 sm:px-4">

    {{-- ENCABEZADO --}}
    <div class="encabezado-preguntas">

        {{-- TÍTULO E ICONO --}}
        <div class="titulo-preguntas">

            <div class="flex size-16 shrink-0 items-center justify-center rounded-2xl bg-blue-50 dark:bg-blue-500/10">
                <flux:icon.question-mark-circle class="size-9 text-blue-700 dark:text-blue-400" />
            </div>

            <div class="min-w-0">
                <flux:heading size="xl" level="1">
                    Preguntas
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    Administre las preguntas agrupadas por factores y temas.
                </flux:text>
            </div>

        </div>

        {{-- INDICADORES --}}
        <div class="indicadores-preguntas">

            {{-- TOTAL --}}
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <div class="icono-estadistica bg-blue-50 dark:bg-blue-500/10">
                    <flux:icon.list-bullet class="size-5 text-blue-600 dark:text-blue-400" />
                </div>

                <div class="contenido-estadistica">
                    <p class="etiqueta-estadistica text-zinc-500 dark:text-zinc-400">
                        Total preguntas
                    </p>

                    <p class="valor-estadistica text-zinc-900 dark:text-white">
                        {{ $estadisticas->total ?? 0 }}
                    </p>
                </div>

            </div>

            {{-- ACTIVAS --}}
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <div class="icono-estadistica bg-green-50 dark:bg-green-500/10">
                    <flux:icon.check-circle class="size-5 text-green-600 dark:text-green-400" />
                </div>

                <div class="contenido-estadistica">
                    <p class="etiqueta-estadistica text-zinc-500 dark:text-zinc-400">
                        Activas
                    </p>

                    <p class="valor-estadistica text-green-600 dark:text-green-400">
                        {{ $estadisticas->activas ?? 0 }}
                    </p>
                </div>

            </div>

            {{-- INACTIVAS --}}
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <div class="icono-estadistica bg-red-50 dark:bg-red-500/10">
                    <flux:icon.x-circle class="size-5 text-red-600 dark:text-red-400" />
                </div>

                <div class="contenido-estadistica">
                    <p class="etiqueta-estadistica text-zinc-500 dark:text-zinc-400">
                        Inactivas
                    </p>

                    <p class="valor-estadistica text-red-600 dark:text-red-400">
                        {{ $estadisticas->inactivas ?? 0 }}
                    </p>
                </div>

            </div>

        </div>

    </div>



    {{-- arreglo de iconos --}}
    @php
        $iconosFactores = [
            'Recomendación' => 'star',
            'Atribución institucional' => 'building-library',
            'Difusión y acceso' => 'megaphone',
            'Vinculación municipal' => 'link',
            'Atención y acompañamiento' => 'user-group',
            'Calidad del servicio o contenido' => 'check-badge',
            'Condiciones de prestación' => 'adjustments-horizontal',
            'Utilidad y resultados' => 'chart-bar',
            'Mejoras y necesidades futuras' => 'light-bulb',
            'Incidencias e integridad' => 'shield-check',
        ];
    @endphp

    @if (!$factorActual)

        {{-- TÍTULO DE SECCIÓN --}}
        <div class="flex items-center justify-between gap-3">

            <div>
                <flux:heading size="lg">
                    Factores de evaluación
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    Seleccione un factor para consultar sus preguntas.
                </flux:text>
            </div>

            <flux:badge color="zinc">
                {{ $factores->count() }} factores
            </flux:badge>

        </div>



        {{-- TARJETAS DE FACTORES --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

            @foreach ($factores as $factor)
                <a href="{{ route('administracion.preguntas.factor', ['slug' => $factor->slug]) }}" wire:navigate
                    wire:key="factor-{{ $factor->id }}"
                    class="group flex min-h-48 w-full flex-col rounded-2xl border border-zinc-200 bg-white p-5 text-left shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-blue-300 hover:shadow-md dark:border-zinc-700 dark:bg-zinc-900">


                    <div class="flex w-full items-start justify-between gap-3">

                        <div
                            class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700 transition-colors group-hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400">

                            <flux:icon :name="$iconosFactores[$factor->nombre] ?? 'squares-2x2'" class="size-7" />

                        </div>

                        <flux:icon.chevron-right
                            class="size-5 text-zinc-400 transition-transform group-hover:translate-x-1 group-hover:text-blue-600" />

                    </div>

                    <div class="mt-4 flex-1">

                        <flux:heading size="lg">
                            {{ $factor->nombre }}
                        </flux:heading>

                        <flux:text class="mt-1 text-sm">
                            Consulte las preguntas de este factor.
                        </flux:text>

                    </div>

                    <div
                        class="mt-4 flex w-full flex-wrap items-center gap-2 border-t border-zinc-100 pt-4 dark:border-zinc-800">

                        <flux:badge color="blue" size="sm">
                            {{ $factor->preguntas_count }} preguntas
                        </flux:badge>

                        <flux:badge color="zinc" size="sm">
                            {{ $factor->temas_count }} temas
                        </flux:badge>

                    </div>

                </a>
            @endforeach

        </div>
    @else
        {{-- MODULO DE PREGUNTAS --}}
        <div>
            <flux:button :href="route('administracion.preguntas')" wire:navigate variant="ghost" icon="arrow-left">
                Volver a factores
            </flux:button>
        </div>

        {{-- INFORMACIÓN DEL FACTOR SELECCIONADO --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                {{-- ICONO E INFORMACIÓN --}}
                <div class="flex min-w-0 items-center gap-4">

                    {{-- Icono correspondiente al factor --}}
                    <div
                        class="flex size-20 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                        <flux:icon :name="$iconosFactores[$factorActual->nombre] ?? 'squares-2x2'" class="size-10" />
                    </div>

                    {{-- Información --}}
                    <div class="min-w-0">

                        <flux:text
                            class="text-xs font-semibold uppercase tracking-wide text-blue-700 dark:text-blue-400">
                            Factor seleccionado
                        </flux:text>

                        <flux:heading size="xl" class="mt-1">
                            {{ $factorActual->nombre }}
                        </flux:heading>

                        <flux:text class="mt-1 text-sm">
                            Preguntas asociadas a este factor.
                        </flux:text>

                    </div>

                </div>

                {{-- CONTADORES Y ACCIONES --}}
                <div class="flex flex-wrap items-center gap-2 lg:justify-end">

                    <flux:badge color="blue" size="lg">
                        {{ $factorActual->preguntas_count }} preguntas
                    </flux:badge>

                    <flux:badge color="zinc" size="lg">
                        {{ $factorActual->temas_count }} temas
                    </flux:badge>

                    <flux:modal.trigger name="temas-factor">
                        <flux:button variant="outline" size="sm" icon="book-open">
                            Ver temas
                        </flux:button>
                    </flux:modal.trigger>

                    <flux:button variant="primary" size="sm" icon="plus" wire:click="abrirNuevaPregunta">
                        Nueva pregunta
                    </flux:button>

                </div>

            </div>

        </div>


        {{-- MODAL DE TEMAS --}}
        <flux:modal name="temas-factor" class="w-full max-w-xl">

            <div class="space-y-5">

                {{-- Encabezado --}}
                <div>
                    <flux:heading size="lg">
                        Temas del factor
                    </flux:heading>

                    <flux:text class="mt-1 text-sm">
                        {{ $factorActual->nombre }}
                    </flux:text>
                </div>

                {{-- Cantidad --}}
                <div class="flex items-center justify-between">
                    <flux:text class="text-sm">
                        Temas registrados
                    </flux:text>

                    <flux:badge color="blue">
                        {{ $temas->count() }}
                    </flux:badge>
                </div>

                {{-- Listado con scroll --}}
                <div class="max-h-80 space-y-2 overflow-y-auto pr-2">

                    @forelse ($temas as $tema)
                        <div wire:key="tema-modal-{{ $tema->id }}"
                            class="flex items-center gap-3 rounded-xl border border-zinc-200 p-3 dark:border-zinc-700">

                            <div
                                class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                <flux:icon.book-open class="size-5" />
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $tema->nombre }}
                                </p>
                            </div>

                        </div>

                    @empty

                        <div class="py-8 text-center">
                            <flux:icon.inbox class="mx-auto mb-3 size-9 text-zinc-400" />

                            <flux:text class="text-sm">
                                No hay temas registrados.
                            </flux:text>
                        </div>
                    @endforelse

                </div>

            </div>
        </flux:modal>


        {{-- MODAL PARA CREAR PREGUNTAS --}}
        <flux:modal name="nueva-pregunta" class="w-full max-w-lg" @close="cerrarNuevaPregunta">
            <div class="space-y-6">

                {{-- ENCABEZADO --}}
                <div>
                    <flux:heading size="xl">
                        {{ $preguntaId ? 'Editar pregunta' : 'Nueva pregunta' }}
                    </flux:heading>

                    <flux:text class="mt-2">
                        {{ $preguntaId
                            ? 'Modifique la información de la pregunta seleccionada.'
                            : 'Complete la información para registrar una nueva pregunta.' }}
                    </flux:text>
                </div>

                {{-- FORMULARIO --}}
                <form wire:submit="guardar" class="space-y-5">

                    {{-- FACTOR --}}
                    <flux:input label="Factor" :value="$factorActual->nombre" icon="squares-2x2" readonly />

                    {{-- TEMA --}}
                    <flux:select wire:model="temaId" label="Tema">
                        <flux:select.option value="">
                            Seleccione un tema
                        </flux:select.option>

                        @foreach ($temas as $tema)
                            <flux:select.option :value="$tema->id" wire:key="tema-nueva-{{ $tema->id }}">
                                {{ $tema->nombre }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

                    {{-- OBLIGATORIA --}}
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <flux:radio.group wire:model="obligatoria" label="¿La pregunta es obligatoria?"
                            :disabled="$esPredeterminada">
                            <div class="mt-2 flex items-center gap-5">
                                <flux:radio value="1" label="Sí" />
                                <flux:radio value="0" label="No" />
                            </div>
                        </flux:radio.group>
                    </div>

                    {{-- TEXTO --}}
                    <flux:textarea wire:model="texto" label="Texto de la pregunta"
                        placeholder="Escriba la pregunta aquí..." rows="3" resize="vertical" />


                    {{-- TIPOS DE RESPUESTA --}}

                    {{-- TIPOS DE RESPUESTA --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            Tipos de respuesta
                        </label>

                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            Seleccione uno o varios tipos de respuesta.
                        </p>

                        <div class="mt-3 space-y-3">
                            @foreach ($tiposRespuesta as $tipo)
                                <label wire:key="tipo-respuesta-{{ $tipo->id }}"
                                    class="flex cursor-pointer items-center gap-3">

                                    <input type="checkbox" wire:model="tiposRespuestaSeleccionados"
                                        value="{{ $tipo->id }}" @disabled($esPredeterminada)
                                        class="size-4 rounded border-zinc-300 text-blue-600
                           focus:ring-blue-500 dark:border-zinc-600" />

                                    <span class="text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $tipo->nombre }}
                                    </span>

                                </label>
                            @endforeach
                        </div>
                    </div>
                    {{-- BOTONES --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end">

                        <flux:button type="button" variant="ghost" wire:click="cerrarNuevaPregunta">
                            Cancelar
                        </flux:button>

                        <flux:button type="submit" variant="primary" icon="check" wire:loading.attr="disabled"
                            wire:target="guardar">
                            Guardar pregunta
                        </flux:button>

                    </div>

                </form>
            </div>
        </flux:modal>


        {{-- MODAL CONFIGURAR RESPUESTAS --}}

        {{-- MODAL CONFIGURAR RESPUESTAS --}}
        <flux:modal name="configurar-respuestas" class="w-full max-w-xl">

            <div class="space-y-6">

                {{-- ENCABEZADO --}}
                <div>
                    <flux:heading size="xl">
                        Configurar respuestas
                    </flux:heading>

                    <flux:text class="mt-2">
                        Configure las opciones de respuesta de la pregunta.
                    </flux:text>
                </div>


                {{-- ESTADO DE CONFIGURACIÓN --}}
                <div
                    class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-700 dark:bg-zinc-800/30">

                    {{-- ENCABEZADO --}}
                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <div class="flex items-center gap-2">
                            <flux:icon.clipboard-document-check class="size-5 text-zinc-500 dark:text-zinc-400" />

                            <flux:heading size="sm">
                                Estado de configuración
                            </flux:heading>
                        </div>


                        {{-- ESTADO DE LA PREGUNTA --}}
                        @if ($preguntaConfiguracionActiva)
                            <flux:badge color="green" size="sm" icon="check-circle">
                                Activa
                            </flux:badge>
                        @elseif ($estadoConfiguracion['completo'] ?? false)
                            <flux:badge color="blue" size="sm" icon="check-circle">
                                Lista para activar
                            </flux:badge>
                        @else
                            <flux:badge color="amber" size="sm" icon="exclamation-circle">
                                Pendiente
                            </flux:badge>
                        @endif


                    </div>

                    {{-- DESCRIPCIÓN --}}

                    <flux:text class="mt-2 text-xs">

                        @if ($preguntaConfiguracionActiva)
                            Esta pregunta se encuentra activa y disponible para
                            utilizarse en las encuestas.
                        @elseif ($estadoConfiguracion['completo'] ?? false)
                            Todos los tipos de respuesta están configurados correctamente.
                            Puede activar esta pregunta cuando lo desee.
                        @else
                            Complete los tipos de respuesta pendientes para poder
                            activar esta pregunta.
                        @endif

                    </flux:text>


                    {{-- DETALLE DE TIPOS DE RESPUESTA --}}
                    @if (!empty($estadoConfiguracion['detalles']))

                        <div class="mt-4 space-y-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">

                            @foreach ($estadoConfiguracion['detalles'] as $detalle)
                                <div class="flex items-start gap-3">

                                    {{-- ICONO DE ESTADO --}}
                                    @if ($detalle['completo'])
                                        <flux:icon.check-circle
                                            class="mt-0.5 size-5 shrink-0 text-green-600 dark:text-green-400" />
                                    @else
                                        <flux:icon.exclamation-circle class="mt-0.5 size-5 shrink-0 text-amber-500" />
                                    @endif

                                    {{-- INFORMACIÓN --}}
                                    <div class="min-w-0 flex-1">

                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $detalle['nombre'] }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $detalle['mensaje'] }}
                                        </p>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    @endif

                </div>


                @if (count($tiposConfiguracionDisponibles) > 0)

                    {{-- TIPO DE RESPUESTA --}}
                    <flux:select wire:model.live="tipoRespuestaConfiguracionId" label="Tipo de respuesta">
                        @foreach ($tiposConfiguracionDisponibles as $tipo)
                            <flux:select.option :value="$tipo['id']">
                                {{ $tipo['nombre'] }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

                    @php
                        $tipoActual = collect($tiposConfiguracionDisponibles)->firstWhere(
                            'id',
                            $tipoRespuestaConfiguracionId,
                        );

                        $esSeleccion = in_array(
                            $tipoActual['nombre'] ?? null,
                            ['Selección única', 'Selección múltiple'],
                            true,
                        );
                    @endphp

                    {{-- CONFIGURACIÓN DE ESCALA --}}
                    @if (($tipoActual['nombre'] ?? null) === 'Escala de 0 a 10')

                        <form wire:key="form-escala-{{ $preguntaConfiguracionId }}"
                            wire:submit="guardarConfiguracionRespuestas" class="space-y-5">

                            <flux:select wire:model.live="escalaSeleccionada" label="Seleccione una escala">
                                <flux:select.option value="">
                                    Seleccione una escala
                                </flux:select.option>

                                @foreach ($escalas as $escala)
                                    <flux:select.option :value="$escala->id">
                                        {{ $escala->nombre }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>


                            {{-- VISTA PREVIA --}}
                            @if ($escalaSeleccionada && $escalaActual)

                                <div
                                    class="rounded-xl border border-blue-200 bg-blue-50/40 p-4 dark:border-blue-500/30 dark:bg-blue-500/5">

                                    <div
                                        class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">

                                        <p class="mb-3 text-sm font-semibold">
                                            Vista previa de la escala
                                        </p>

                                        <div class="flex flex-wrap gap-1.5">

                                            @for ($numero = $escalaActual->minimo; $numero <= $escalaActual->maximo; $numero++)
                                                <div
                                                    class="flex h-8 min-w-8 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 px-2 text-xs font-semibold text-blue-700 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300">
                                                    {{ $numero }}
                                                </div>
                                            @endfor

                                        </div>

                                        @if ($escalaActual->permite_no_sabe || $escalaActual->permite_no_aplica)

                                            <div class="mt-2 flex flex-wrap gap-2">

                                                @if ($escalaActual->permite_no_sabe)
                                                    <div
                                                        class="rounded-lg border border-zinc-200 px-3 py-1.5 text-xs dark:border-zinc-700">
                                                        No sabe
                                                    </div>
                                                @endif

                                                @if ($escalaActual->permite_no_aplica)
                                                    <div
                                                        class="rounded-lg border border-zinc-200 px-3 py-1.5 text-xs dark:border-zinc-700">
                                                        No aplica
                                                    </div>
                                                @endif

                                            </div>

                                        @endif

                                    </div>
                                </div>

                            @endif

                            <div class="flex justify-end gap-3 border-t border-zinc-200 pt-5 dark:border-zinc-700">

                                <flux:modal.close>
                                    <flux:button type="button" variant="ghost">
                                        Cancelar
                                    </flux:button>
                                </flux:modal.close>

                                <flux:button type="submit" variant="primary" icon="check">
                                    Guardar configuración
                                </flux:button>

                            </div>

                        </form>

                        {{-- CONFIGURACIÓN DE SELECCIÓN ÚNICA Y MÚLTIPLE --}}
                    @elseif ($esSeleccion)
                        <form
                            wire:key="form-opciones-{{ $preguntaConfiguracionId }}-{{ $tipoRespuestaConfiguracionId }}"
                            wire:submit="guardarOpcionesRespuesta" class="space-y-5">

                            <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">

                                {{-- ENCABEZADO DE OPCIONES --}}
                                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">

                                    <div>
                                        <flux:heading size="sm">
                                            Opciones de respuesta
                                        </flux:heading>

                                        <flux:text class="mt-1 text-xs">
                                            Agregue al menos dos opciones. El valor es el código interno.
                                        </flux:text>
                                    </div>

                                    <flux:button type="button" variant="primary" size="sm" icon="plus"
                                        wire:click="agregarOpcionRespuesta">
                                        Agregar
                                    </flux:button>

                                </div>

                                {{-- LISTADO DINÁMICO --}}
                                <div class="space-y-3">

                                    @foreach ($opcionesConfiguracion as $indice => $opcion)
                                        <div wire:key="opcion-{{ $tipoRespuestaConfiguracionId }}-{{ $opcion['id'] ?? 'nueva-' . $indice }}"
                                            class="rounded-xl bg-zinc-50 p-3 dark:bg-zinc-800/50">

                                            {{-- VALOR Y ETIQUETA --}}
                                            <div
                                                class="grid grid-cols-1 items-start gap-2 sm:grid-cols-[minmax(0,1fr)_minmax(0,1.5fr)_auto]">

                                                <flux:input
                                                    wire:model="opcionesConfiguracion.{{ $indice }}.valor"
                                                    label="Valor" placeholder="ej. si" />

                                                <flux:input
                                                    wire:model="opcionesConfiguracion.{{ $indice }}.etiqueta"
                                                    label="Etiqueta" placeholder="ej. Sí" />

                                                <div class="sm:pt-6">
                                                    <flux:button type="button" variant="danger" size="sm"
                                                        wire:click="quitarOpcionRespuesta({{ $indice }})"
                                                        :disabled="$indice < 2 || count($opcionesConfiguracion) <= 2">
                                                        Quitar
                                                    </flux:button>
                                                </div>

                                            </div>

                                            {{-- CHECKBOXES --}}
                                            <div
                                                class="mt-3 flex flex-wrap gap-5 border-t border-zinc-200 pt-3 dark:border-zinc-700">

                                                <flux:checkbox
                                                    wire:model="opcionesConfiguracion.{{ $indice }}.es_excluyente"
                                                    label="Es excluyente" />

                                                <flux:checkbox
                                                    wire:model.live="opcionesConfiguracion.{{ $indice }}.habilita_texto"
                                                    label="Habilita texto" />

                                            </div>

                                            {{-- ETIQUETA ADICIONAL --}}
                                            @if (!empty($opcion['habilita_texto']))
                                                <div class="mt-3">

                                                    <flux:input
                                                        wire:model="opcionesConfiguracion.{{ $indice }}.etiqueta_texto_adicional"
                                                        label="Etiqueta del texto adicional"
                                                        placeholder="Ej. Especifique su respuesta" />

                                                </div>
                                            @endif

                                        </div>
                                    @endforeach

                                </div>

                                @error('opcionesConfiguracion')
                                    <p class="mt-3 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- BOTONES --}}
                            <div class="flex justify-end gap-3 border-t border-zinc-200 pt-5 dark:border-zinc-700">

                                <flux:modal.close>
                                    <flux:button type="button" variant="ghost">
                                        Cancelar
                                    </flux:button>
                                </flux:modal.close>

                                <flux:button type="submit" variant="primary" icon="check"
                                    wire:loading.attr="disabled" wire:target="guardarOpcionesRespuesta">
                                    Guardar configuración
                                </flux:button>

                            </div>

                        </form>

                    @endif
                @else
                    <div class="py-5 text-center">
                        <flux:text>
                            No hay tipos de respuesta configurables para esta pregunta.
                        </flux:text>
                    </div>

                @endif

            </div>

        </flux:modal>




        <x-confirmacion nombre="confirmar-estado-pregunta" :titulo="$nuevoEstadoPregunta ? 'Activar pregunta' : 'Desactivar pregunta'" :mensaje="$nuevoEstadoPregunta
            ? '<strong>¿Está seguro de que desea activar la pregunta?</strong><br>' . e($nombrePreguntaEstado)
            : '<strong>¿Está seguro de que desea desactivar la pregunta?</strong><br>' . e($nombrePreguntaEstado)"
            :texto-confirmar="$nuevoEstadoPregunta ? 'Sí, activar' : 'Sí, desactivar'"
            :color="$nuevoEstadoPregunta ? 'primary' : 'danger'" accion="cambiarEstadoPregunta" />


        {{-- MENSAJE DE CONFIRMACIÓN --}}
        <x-alerta />
        {{-- panel principal --}}
        <div
            class="tabla-preguntas overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <x-data-table :headers="$headers" :rows="$this->rows" :advance-filter="true"
                empty-message="No se encontraron preguntas.">

                @interact('id', $row)
                    {{ $row->id }}
                @endinteract

                @interact('codigo', $row)
                    <flux:badge color="blue" size="sm">
                        {{ $row->codigo }}
                    </flux:badge>
                @endinteract


                @interact('texto', $row)
                    <div class="contenido-pregunta">

                        {{-- TEXTO DE LA PREGUNTA --}}
                        <p class="texto-pregunta" title="{{ $row->texto }}">
                            {{ $row->texto }}
                        </p>

                        {{-- ETIQUETAS --}}
                        @if ($row->es_nps || $row->es_predeterminada)
                            <div class="mt-2 flex flex-wrap items-center gap-2">

                                @if ($row->es_nps)
                                    <flux:badge color="purple" size="sm">
                                        NPS
                                    </flux:badge>
                                @endif

                                @if ($row->es_predeterminada)
                                    <flux:badge color="blue" size="sm">
                                        Es predeterminada
                                    </flux:badge>
                                @endif

                            </div>
                        @endif

                    </div>
                @endinteract

                @interact('tema.nombre', $row)
                    @if ($row->tema)
                        <flux:badge color="blue" size="sm">
                            {{ $row->tema->nombre }}
                        </flux:badge>
                    @else
                        <flux:badge color="zinc" size="sm">
                            Sin tema
                        </flux:badge>
                    @endif
                @endinteract

                @interact('tiposRespuesta.nombre', $row)
                    <div class="flex flex-wrap items-center gap-1.5">
                        @forelse ($row->tiposRespuesta as $tipo)
                            <flux:badge color="zinc" size="sm">
                                {{ $tipo->nombre }}
                            </flux:badge>
                        @empty
                            <flux:badge color="zinc" size="sm">
                                Sin tipo
                            </flux:badge>
                        @endforelse
                    </div>
                @endinteract

                @interact('obligatoria', $row)
                    <flux:badge :color="$row->obligatoria ? 'blue' : 'zinc'" size="sm">
                        {{ $row->obligatoria ? 'Sí' : 'No' }}
                    </flux:badge>
                @endinteract

                @interact('activo', $row)
                    <flux:badge :color="$row->activo ? 'green' : 'red'" size="sm">
                        {{ $row->activo ? 'Activo' : 'Inactivo' }}
                    </flux:badge>
                @endinteract

                {{-- ACCIONES --}}
                @interact('actions', $row)
                    <flux:dropdown position="bottom" align="center">

                        <flux:button icon="ellipsis-vertical" variant="ghost" size="sm" aria-label="Acciones" />

                        <flux:menu>

                            <flux:menu.item disabled>
                                Acciones de la pregunta
                            </flux:menu.item>

                            <flux:menu.separator />

                            <flux:menu.item icon="pencil-square" wire:click="editar({{ $row->id }})">
                                Editar pregunta
                            </flux:menu.item>

                            {{-- configurar respuestas --}}
                            @if ($row->tiposRespuesta->contains(fn($tipo) => $tipo->nombre !== 'Texto abierto'))
                                <flux:menu.item icon="adjustments-horizontal"
                                    wire:click="configurarRespuestas({{ $row->id }})">
                                    Configurar respuestas
                                </flux:menu.item>
                            @endif
                            <flux:menu.separator />
                            @if (!$row->es_predeterminada)
                                <flux:menu.item :icon="$row->activo ? 'no-symbol' : 'check-circle'"
                                    :variant="$row->activo ? 'danger' : 'default'"
                                    wire:click="confirmarCambioEstado({{ $row->id }})">
                                    {{ $row->activo ? 'Desactivar pregunta' : 'Activar pregunta' }}
                                </flux:menu.item>
                            @endif
                        </flux:menu>

                    </flux:dropdown>
                @endinteract


            </x-data-table>
        </div>
    @endif
</div>
