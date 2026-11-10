<div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-6 sm:px-4">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex items-center gap-4">

            <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-blue-50 dark:bg-blue-500/10">
                <flux:icon.question-mark-circle class="size-10 text-blue-700 dark:text-blue-400" />
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

        {{-- <div class="flex flex-wrap items-center gap-3">

            <flux:badge color="blue" size="lg">
                {{ $totalPreguntas }} preguntas
            </flux:badge>

            <flux:button variant="primary" icon="plus" disabled>
                Nueva pregunta
            </flux:button>

        </div> --}}
    </div>

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

        {{-- TARJETAS DE FACTORES --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

            @foreach ($factores as $factor)
                <button type="button" wire:key="factor-{{ $factor->id }}"
                    wire:click="seleccionarFactor({{ $factor->id }})"
                    class="group flex min-h-48 w-full flex-col rounded-2xl border border-zinc-200 bg-white p-5 text-left shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-blue-300 hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-blue-500">

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

                </button>
            @endforeach

        </div>
    @else
        {{-- MODULO DE PREGUNTAS --}}
        <div>
            <flux:button variant="ghost" icon="arrow-left" wire:click="regresarFactores">
                Volver a factores
            </flux:button>
        </div>
        {{-- información del factor --}}
        <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-5 dark:border-blue-500/20 dark:bg-blue-500/5">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <flux:text class="text-xs font-semibold uppercase tracking-wide text-blue-700 dark:text-blue-400">
                        Factor seleccionado
                    </flux:text>

                    <flux:heading size="xl" class="mt-1">
                        {{ $factorActual->nombre }}
                    </flux:heading>

                    <flux:text class="mt-1 text-sm">
                        Preguntas asociadas a este factor.
                    </flux:text>
                </div>

                <div class="flex flex-wrap gap-2">

                    <flux:badge color="blue" size="lg">
                        {{ $factorActual->preguntas_count }} preguntas
                    </flux:badge>

                    <flux:badge color="zinc" size="lg">
                        {{ $factorActual->temas_count }} temas
                    </flux:badge>

                </div>

            </div>

        </div>
        {{-- panel principal --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <x-data-table
            :headers="$headers"
            :rows="$this->rows"
            :advance-filter="true"
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
                <div class="flex items-start gap-3">

                    <div class="min-w-0 max-w-xl">

                        <p class="whitespace-normal font-medium text-zinc-900 dark:text-zinc-100">
                            {{ $row->texto }}
                        </p>

                        @if ($row->es_nps)
                            <flux:badge color="blue" size="sm" class="mt-2">
                                NPS
                            </flux:badge>
                        @endif

                    </div>

                </div>
            @endinteract

            @interact('obligatoria', $row)
                <flux:badge
                    :color="$row->obligatoria ? 'blue' : 'zinc'"
                    size="sm"
                >
                    {{ $row->obligatoria ? 'Sí' : 'No' }}
                </flux:badge>
            @endinteract

            @interact('activo', $row)
                <flux:badge
                    :color="$row->activo ? 'green' : 'red'"
                    size="sm"
                >
                    {{ $row->activo ? 'Activo' : 'Inactivo' }}
                </flux:badge>
            @endinteract


            </x-data-table>
        </div>
    @endif
</div>

