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
            <form>
                
            </form>
        </div>
    </flux:modal>
</div>
