<div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6">
    {{-- Encabezado --}}
    <div class="encabezado-preguntas">

        <div class="titulo-preguntas">

            <div
                class="flex size-12 shrink-0 items-center justify-center
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
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">


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
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">


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
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

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
            <div
                class="tarjeta-estadistica border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

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

    <x-alerta />
    {{-- tabla de plantillas asignadas --}}
    <div
        class="overflow-hidden rounded-xl border border-zinc-200
                bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <x-data-table :headers="$headers" :rows="$this->rows" :advance-filter="true"
            empty-message="Actualmente no tienes plantillas asignadas.">
            {{-- ID --}}
            @interact('id', $row)
                <span class="font-medium text-zinc-500">
                    {{ $row->id }}
                </span>
            @endinteract
            {{-- Código --}}
            @interact('codigo', $row)
                <flux:badge color="blue" size="sm">
                    {{ $row->codigo }}
                </flux:badge>
            @endinteract
            {{-- nombre --}}
            @interact('nombre', $row)
                <div class="max-w-sm whitespace-normal">
                    <span class="font-medium text-zinc-800
                                 dark:text-zinc-100">
                        {{ $row->nombre }}
                    </span>
                </div>
            @endinteract
            {{-- descripcion --}}
            @interact('descripcion', $row)
                <div class="max-w-xs whitespace-normal">

                    @if ($row->descripcion)
                        <span class="text-sm text-zinc-600
                                     dark:text-zinc-400">
                            {{ $row->descripcion }}
                        </span>
                    @else
                        <span class="text-sm italic text-zinc-400">
                            Sin descripción
                        </span>
                    @endif

                </div>
            @endinteract
            {{-- Cantidad de preguntas --}}
            @interact('preguntas_count', $row)
                <flux:badge :color="$row->preguntas_count > 0 ? 'blue' : 'zinc'" size="sm">
                    {{ $row->preguntas_count }}
                    {{ $row->preguntas_count === 1 ? 'pregunta' : 'preguntas' }}
                </flux:badge>
            @endinteract

            {{-- Estado --}}
            @interact('estado', $row)
                @switch($row->estado)
                    @case('borrador')
                        <flux:badge color="amber" size="sm">
                            Borrador
                        </flux:badge>
                    @break

                    @case('publicada')
                        <flux:badge color="green" size="sm">
                            Publicada
                        </flux:badge>
                    @break

                    @case('inactiva')
                        <flux:badge color="red" size="sm">
                            Inactiva
                        </flux:badge>
                    @break

                    @default
                        <flux:badge color="zinc" size="sm">
                            {{ ucfirst($row->estado) }}
                        </flux:badge>
                @endswitch
            @endinteract

            {{-- acciones --}}
            @interact('actions', $row)
                <flux:dropdown position="bottom" align="end">
                    <flux:button icon="ellipsis-horizontal" variant="ghost" size="sm" />
                    <flux:menu>

                        @if (\Illuminate\Support\Facades\Route::has('asignador.plantillas.preguntas'))
                            <flux:menu.item icon="clipboard-document-list"
                                :href="route('asignador.plantillas.preguntas', $row->id)" wire:navigate>
                                Gestionar preguntas
                            </flux:menu.item>
                        @else
                            <flux:menu.item icon="clipboard-document-list" disabled>
                                Gestionar preguntas
                            </flux:menu.item>
                        @endif

                    </flux:menu>
                </flux:dropdown>
            @endinteract
        </x-data-table>
    </div>


</div>
