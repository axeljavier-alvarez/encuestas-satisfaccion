<div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-6 sm:px-4">
    {{-- ENCABEZADO --}}
    <div class="encabezado-preguntas">
        {{-- TÍTULO E ICONO --}}
        <div class="titulo-preguntas">
            <div class="flex size-16 shrink-0 items-center justify-center rounded-2xl bg-blue-50 dark:bg-blue-500/10">
                <flux:icon.document-text class="size-9 text-blue-700 dark:text-blue-400" />
            </div>
            <div class="min-w-0">
                <flux:heading size="xl" level="1">
                    Plantillas
                </flux:heading>
                <flux:text class="mt-1 text-sm">
                    Administre las plantillas utilizadas para las encuestas.
                </flux:text>
            </div>
        </div>
        {{-- indicadores --}}
        <div class="indicadores-preguntas">
            {{-- TOTAL DE PLANTILLAS --}}
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="icono-estadistica bg-blue-50 dark:bg-blue-500/10">
                    <flux:icon.document-duplicate class="size-5 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="contenido-estadistica">

                    <p class="etiqueta-estadistica text-zinc-500 dark:text-zinc-400">
                        Total plantillas
                    </p>

                    <p class="valor-estadistica text-zinc-900 dark:text-white">
                        {{ $estadisticas->total ?? 0 }}
                    </p>

                </div>
            </div>
            {{-- plantillas activas --}}
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
            {{-- plantillas inactivas --}}
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
    {{-- encabezado del listado --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <flux:heading size="lg">
                Listado de plantillas
            </flux:heading>
            <flux:text class="mt-1 text-sm">
                Consulte y administre las plantillas registradas.
            </flux:text>

        </div>
        <flux:button variant="primary" icon="plus" wire:click="abrirNuevaPlantilla">

            Nueva plantilla

        </flux:button>

    </div>
    {{-- modal crear / editar plantilla --}}
    <flux:modal name="nueva-plantilla" class="w-full max-w-lg" @close="cerrarNuevaPlantilla">
        <div class="space-y-6">
            {{-- encabezado --}}
            <div>
                <flux:heading size="xl">
                    {{ $plantillaId ? 'Editar plantilla' : 'Nueva plantilla' }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $plantillaId
                        ? 'Modifique la información de la plantilla seleccionada.'
                        : 'Complete la información para registrar una nueva plantilla.' }}
                </flux:text>
            </div>
            {{-- formulario --}}
            <form wire:submit="guardar" class="space-y-5">
                {{-- nombre --}}
                <flux:input wire:model="nombre" label="Nombre de la plantilla"
                    placeholder="Ej. Encuesta de satisfacción" />
                {{-- descripcion --}}
                <flux:textarea wire:model="descripcion" label="Descripción"
                    placeholder="Describa el propósito de la plantilla..." rows="3" resize="vertical" />
                {{-- ESTADO --}}
                <flux:select wire:model="estado" label="Estado de la plantilla">
                    <flux:select.option value="borrador">
                        Borrador
                    </flux:select.option>

                    <flux:select.option value="publicada">
                        Publicada
                    </flux:select.option>
                </flux:select>
                {{-- BOTONES --}}
                <div class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end">
                    <flux:button type="button" variant="ghost" wire:click="cerrarNuevaPlantilla">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary" icon="check" wire:loading.attr="disabled"
                        wire:target="guardar">
                        {{ $plantillaId ? 'Guardar cambios' : 'Guardar plantilla' }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
    {{-- CONFIRMACIÓN DE CAMBIO DE ESTADO --}}
    <x-confirmacion nombre="confirmar-estado-plantilla" :titulo="$nuevoEstadoPlantilla ? 'Activar plantilla' : 'Desactivar plantilla'" :mensaje="$nuevoEstadoPlantilla
        ? '<strong>¿Está seguro de que desea activar esta plantilla?</strong><br>' . e($nombrePlantillaEstado)
        : '<strong>¿Está seguro de que desea desactivar esta plantilla?</strong><br>' . e($nombrePlantillaEstado)"
        :texto-confirmar="$nuevoEstadoPlantilla ? 'Sí, activar' : 'Sí, desactivar'"
        :color="$nuevoEstadoPlantilla ? 'primary' : 'danger'" accion="cambiarEstadoPlantilla" />
    {{--  alerta --}}
    <x-alerta />
    {{-- tabla de plantillas --}}
    <div
        class="tabla-preguntas overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <x-data-table :headers="$headers" :rows="$this->rows" :advance-filter="true"
            empty-message="No se encontraron plantillas.">

            @interact('id', $row)
                {{ $row->id }}
            @endinteract

            @interact('codigo', $row)
                <flux:badge color="blue" size="sm">
                    {{ $row->codigo }}
                </flux:badge>
            @endinteract

            @interact('nombre', $row)
                <p class="font-medium text-zinc-900 dark:text-zinc-100">
                    {{ $row->nombre }}
                </p>
            @endinteract

            @interact('descripcion', $row)
                <p class="max-w-xs truncate text-sm text-zinc-600 dark:text-zinc-400" title="{{ $row->descripcion }}">

                    {{ $row->descripcion ?: 'Sin descripción' }}

                </p>
            @endinteract


            @interact('estado', $row)
                <flux:badge :color="$row->estado === 'publicada' ? 'green' : 'amber'" size="sm">

                    {{ ucfirst($row->estado) }}

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
                            Acciones de la plantilla
                        </flux:menu.item>

                        <flux:menu.separator />

                        {{-- EDITAR --}}
                        <flux:menu.item icon="pencil-square" wire:click="editar({{ $row->id }})">

                            Editar plantilla

                        </flux:menu.item>

                        <flux:menu.separator />

                        {{-- ACTIVAR / DESACTIVAR --}}
                        <flux:menu.item :icon="$row->activo ? 'no-symbol' : 'check-circle'"
                            :variant="$row->activo ? 'danger' : 'default'"
                            wire:click="confirmarCambioEstado({{ $row->id }})">

                            {{ $row->activo ? 'Desactivar plantilla' : 'Activar plantilla' }}

                        </flux:menu.item>

                    </flux:menu>

                </flux:dropdown>
            @endinteract

        </x-data-table>
    </div>


</div>
