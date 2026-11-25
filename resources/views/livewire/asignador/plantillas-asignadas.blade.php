<div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6">
     {{-- Encabezado --}}
    <div class="encabezado-preguntas">

        <div class="titulo-preguntas">

            <div class="flex size-12 shrink-0 items-center justify-center
                        rounded-xl bg-blue-50 text-blue-700
                        dark:bg-blue-950 dark:text-blue-400">

                <flux:icon.document-text class="size-6" />

            </div>

            <div>
                <flux:heading size="xl">
                    Plantillas asignadas
                </flux:heading>

                <flux:text class="mt-1">
                    Consulta y gestiona las plantillas que te han sido asignadas.
                </flux:text>
            </div>

        </div>

        {{-- Indicadores --}}
        <div class="indicadores-preguntas cuatro-indicadores">

            {{-- Total --}}
            <div class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">


                <div class="icono-estadistica bg-blue-50 text-blue-600">
                    <flux:icon.document-text class="size-5" />
                </div>

                <div class="contenido-estadistica">
                    <span class="etiqueta-estadistica">
                        Total asignadas
                    </span>

                    <span class="valor-estadistica">
                        {{ $estadisticas->total ?? 0 }}
                    </span>
                </div>

            </div>

            {{-- Borradores --}}
            <div class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">


                <div class="icono-estadistica bg-amber-50 text-amber-600">
                    <flux:icon.pencil-square class="size-5" />
                </div>

                <div class="contenido-estadistica">
                    <span class="etiqueta-estadistica">
                        Borradores
                    </span>

                    <span class="valor-estadistica">
                        {{ $estadisticas->borradores ?? 0 }}
                    </span>
                </div>

            </div>

            {{-- Publicadas --}}
            <div class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <div class="icono-estadistica bg-green-50 text-green-600">
                    <flux:icon.check-circle class="size-5" />
                </div>

                <div class="contenido-estadistica">
                    <span class="etiqueta-estadistica">
                        Publicadas
                    </span>

                    <span class="valor-estadistica">
                        {{ $estadisticas->publicadas ?? 0 }}
                    </span>
                </div>

            </div>

            {{-- Inactivas --}}
            <div class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <div class="icono-estadistica bg-red-50 text-red-600">
                    <flux:icon.no-symbol class="size-5" />
                </div>

                <div class="contenido-estadistica">
                    <span class="etiqueta-estadistica">
                        Inactivas
                    </span>

                    <span class="valor-estadistica">
                        {{ $estadisticas->inactivas ?? 0 }}
                    </span>
                </div>

            </div>

        </div>

    </div>

    
</div>
