<div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-6 sm:px-4">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

        {{-- TÍTULO E ICONO --}}
        <div class="flex min-w-0 items-center gap-4 lg:flex-1">

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
        <div class="grid w-full grid-cols-3 gap-2 sm:gap-3 lg:w-auto lg:grid-cols-3 lg:shrink-0">

            {{-- TOTAL DE PREGUNTAS --}}
            <div
                class="flex min-w-0 items-center gap-2 rounded-xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:gap-3 sm:px-4 lg:w-32">

                <div
                    class="hidden size-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-500/10 sm:flex">
                    <flux:icon.list-bullet class="size-5 text-blue-600 dark:text-blue-400" />
                </div>

                <div class="min-w-0">
                    <p class="text-[11px] font-medium leading-tight text-zinc-500 dark:text-zinc-400 sm:text-xs">
                        Total preguntas
                    </p>

                    <p class="mt-1 text-xl font-bold text-zinc-900 dark:text-white sm:text-2xl">
                        {{ $estadisticas->total ?? 0 }}
                    </p>
                </div>

            </div>

            {{-- PREGUNTAS ACTIVAS --}}
            <div
                class="flex min-w-0 items-center gap-2 rounded-xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:gap-3 sm:px-4 lg:w-32">

                <div
                    class="hidden size-10 shrink-0 items-center justify-center rounded-xl bg-green-50 dark:bg-green-500/10 sm:flex">
                    <flux:icon.check-circle class="size-5 text-green-600 dark:text-green-400" />
                </div>

                <div class="min-w-0">
                    <p class="text-[11px] font-medium leading-tight text-zinc-500 dark:text-zinc-400 sm:text-xs">
                        Activas
                    </p>

                    <p class="mt-1 text-xl font-bold text-green-600 dark:text-green-400 sm:text-2xl">
                        {{ $estadisticas->activas ?? 0 }}
                    </p>
                </div>

            </div>

            {{-- PREGUNTAS INACTIVAS --}}
            <div
                class="flex min-w-0 items-center gap-2 rounded-xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:gap-3 sm:px-4 lg:w-32">

                <div
                    class="hidden size-10 shrink-0 items-center justify-center rounded-xl bg-red-50 dark:bg-red-500/10 sm:flex">
                    <flux:icon.x-circle class="size-5 text-red-600 dark:text-red-400" />
                </div>

                <div class="min-w-0">
                    <p class="text-[11px] font-medium leading-tight text-zinc-500 dark:text-zinc-400 sm:text-xs">
                        Inactivas
                    </p>

                    <p class="mt-1 text-xl font-bold text-red-600 dark:text-red-400 sm:text-2xl">
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


        {{-- panel principal --}}
        <div
            class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
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
                    <flux:badge :color="$row->obligatoria ? 'blue' : 'zinc'" size="sm">
                        {{ $row->obligatoria ? 'Sí' : 'No' }}
                    </flux:badge>
                @endinteract

                @interact('activo', $row)
                    <flux:badge :color="$row->activo ? 'green' : 'red'" size="sm">
                        {{ $row->activo ? 'Activo' : 'Inactivo' }}
                    </flux:badge>
                @endinteract


            </x-data-table>
        </div>
    @endif
</div>
