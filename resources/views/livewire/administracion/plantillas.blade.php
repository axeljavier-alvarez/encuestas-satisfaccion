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

        {{-- INDICADORES --}}
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

            {{-- BORRADORES --}}
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <div class="icono-estadistica bg-amber-50 dark:bg-amber-500/10">
                    <flux:icon.pencil-square class="size-5 text-amber-600 dark:text-amber-400" />
                </div>

                <div class="contenido-estadistica">

                    <p class="etiqueta-estadistica text-zinc-500 dark:text-zinc-400">
                        Borradores
                    </p>

                    <p class="valor-estadistica text-amber-600 dark:text-amber-400">
                        {{ $estadisticas->borradores ?? 0 }}
                    </p>

                </div>

            </div>

            {{-- PUBLICADAS --}}
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <div class="icono-estadistica bg-green-50 dark:bg-green-500/10">
                    <flux:icon.check-circle class="size-5 text-green-600 dark:text-green-400" />
                </div>

                <div class="contenido-estadistica">

                    <p class="etiqueta-estadistica text-zinc-500 dark:text-zinc-400">
                        Publicadas
                    </p>

                    <p class="valor-estadistica text-green-600 dark:text-green-400">
                        {{ $estadisticas->publicadas ?? 0 }}
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

                {{-- NOMBRE DE LA PLANTILLA --}}
                <flux:input wire:model="nombre" label="Nombre de la plantilla"
                    placeholder="Ej. Encuesta de satisfacción" />

                {{-- DESCRIPCIÓN --}}
                <flux:textarea wire:model="descripcion" label="Descripción"
                    placeholder="Describa el propósito de la plantilla..." rows="3" resize="vertical" />

                {{-- ASIGNADOR --}}
                <flux:select wire:model="asignadorId" label="Asignador responsable">

                    <flux:select.option value="">
                        Seleccione un asignador
                    </flux:select.option>

                    @foreach ($asignadores as $asignador)
                        <flux:select.option :value="$asignador->id" wire:key="asignador-{{ $asignador->id }}">

                            {{ $asignador->name }}

                        </flux:select.option>
                    @endforeach

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

    <flux:modal name="cambiar-estado-plantilla" class="w-full max-w-lg">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">
                    Cambiar estado
                </flux:heading>
                <flux:text class="mt-2">
                    Seleccione el nuevo estado de la plantilla.
                </flux:text>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-700 dark:bg-zinc-800/30">
                <flux:text class="text-xs">
                    Plantilla seleccionada
                </flux:text>
                <p class="mt-1 font-medium text-zinc-900 dark:text-zinc-100">
                    {{ $nombrePlantillaEstado }}
                </p>
                <div class="mt-3 flex items-center gap-2">
                    <flux:text class="text-sm">
                        Estado actual:
                    </flux:text>
                    <flux:badge
                        :color="match($estadoActualPlantilla) {
                            'borrador' => 'amber',
                            'publicada' => 'green',
                            'inactiva' => 'red',
                            default => 'zinc',
                        }"
                        size="sm">

                        {{ ucfirst($estadoActualPlantilla) }}
                    </flux:badge>
                </div>
            </div>
            <form wire:submit="cambiarEstadoPlantilla" class="space-y-5">
                <flux:radio.group wire:model.live="nuevoEstadoPlantilla" label="Nuevo estado">
                    <div class="space-y-3">
                        {{-- BORRADOR --}}
                        <div class="rounded-xl border border-zinc-200 p-3 dark:border-zinc-700">

                            <flux:radio value="borrador" label="Borrador"
                                description="Plantilla pendiente de configuración." />

                        </div>

                        {{-- PUBLICADA --}}
                        <div class="rounded-xl border border-zinc-200 p-3 dark:border-zinc-700">

                            <flux:radio value="publicada" label="Publicada"
                                description="Disponible para utilizarse en encuestas." />

                        </div>

                        {{-- INACTIVA --}}
                        <div class="rounded-xl border border-zinc-200 p-3 dark:border-zinc-700">

                            <flux:radio value="inactiva" label="Inactiva"
                                description="No disponible para nuevas encuestas." />

                        </div>

                    </div>
                </flux:radio.group>


                {{-- BOTONES --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end dark:border-zinc-700">

                    <flux:button type="button" variant="ghost" wire:click="cerrarCambioEstado">

                        Cancelar

                    </flux:button>

                    <flux:button type="submit" variant="primary" icon="check"
                        :disabled="$nuevoEstadoPlantilla === $estadoActualPlantilla" wire:loading.attr="disabled"
                        wire:target="cambiarEstadoPlantilla">

                        Guardar estado

                    </flux:button>

                </div>


            </form>
        </div>
    </flux:modal>

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

            @interact('usuarios.name', $row)
                <div class="flex flex-wrap gap-1">

                    @forelse ($row->usuarios->where('rol', 'asignador') as $usuario)
                        <flux:badge color="blue" size="sm">
                            {{ $usuario->name }}
                        </flux:badge>
                    @empty
                        <flux:badge color="zinc" size="sm">
                            Sin asignador
                        </flux:badge>
                    @endforelse

                </div>
            @endinteract


            @interact('estado', $row)
                <flux:badge
                    :color="match ($row->estado) {
                                'borrador' => 'amber',
                                'publicada' => 'green',
                                'inactiva' => 'red',
                                default => 'zinc',
                            }"
                    size="sm">

                    {{ ucfirst($row->estado) }}

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

                        {{-- cambiar estado --}}
                        <flux:menu.item
                        icon="arrows-right-left"
                        wire:click="confirmarCambioEstado({{ $row->id }})">
                        Cambiar estado
                        </flux:menu.item>
                        
                    </flux:menu>

                </flux:dropdown>
            @endinteract

        </x-data-table>
    </div>


</div>
