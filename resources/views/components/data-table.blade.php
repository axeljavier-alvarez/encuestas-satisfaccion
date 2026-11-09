<div class="tabla-asignadores relative overflow-x-auto">

    <div class="p-4 flex items-center justify-between space-x-4">

        <div class="flex gap-2 items-center">

            <flux:select wire:model.live="per_page" wire:key="per-page-select">

                <flux:select.option>5</flux:select.option>

                <flux:select.option>10</flux:select.option>

                <flux:select.option>20</flux:select.option>

                <flux:select.option>50</flux:select.option>

                <flux:select.option>100</flux:select.option>

                <flux:select.option>500</flux:select.option>

                <flux:select.option>1000</flux:select.option>

            </flux:select>

            @if ($actions)
                <flux:dropdown>

                    <flux:button icon:trailing="chevron-down">Actions</flux:button>

                    <flux:menu keep-open class="menu-filtros-tabla">

                        <flux:menu.item icon="plus">New post</flux:menu.item>

                        <flux:menu.separator />

                        <flux:menu.submenu heading="Sort by">

                            <flux:menu.radio.group>

                                <flux:menu.radio checked>Name</flux:menu.radio>

                                <flux:menu.radio>Date</flux:menu.radio>

                                <flux:menu.radio>Popularity</flux:menu.radio>

                            </flux:menu.radio.group>

                        </flux:menu.submenu>

                        <flux:menu.submenu heading="Filter">

                            <flux:menu.checkbox checked>Draft</flux:menu.checkbox>

                            <flux:menu.checkbox checked>Published</flux:menu.checkbox>

                            <flux:menu.checkbox>Archived</flux:menu.checkbox>

                        </flux:menu.submenu>

                        <flux:menu.separator />

                        <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>

                    </flux:menu>

                </flux:dropdown>
            @endif

        </div>

        <div class="flex gap-1">

            <flux:input wire:model.live.debounce.500ms="search" icon="magnifying-glass" placeholder="Buscar ..."
                type="search" wire:key="search-input" />

            @if ($advanceFilter)
                <flux:dropdown>
                    <flux:button icon="funnel" />

                    <flux:menu keep-open class="menu-filtros-tabla">

                        <div class="panel-filtros">

                            <div class="panel-filtros-acciones">
                                <flux:button wire:click="addFilter()" icon="plus" class="boton-agregar-filtro"
                                    size="sm" />

                                <flux:button wire:click="clearFilters()" icon="trash" class="boton-limpiar-filtro"
                                    size="sm" />
                            </div>

                            @foreach ($this->filters as $index => $filter)
                                <div class="fila-filtro" wire:key="filtro-{{ $index }}">

                                    <div class="campo-filtro">
                                        <flux:select wire:key="field-campo-{{ $index }}"
                                            wire:model.live.debounce.500ms="filters.{{ $index }}.field"
                                            placeholder="Campo">
                                            @foreach ($headers as $header)
                                                @if ($header['index'] !== 'actions')
                                                    <flux:select.option value="{{ $header['index'] }}">
                                                        {{ $header['label'] }}
                                                    </flux:select.option>
                                                @endif
                                            @endforeach
                                        </flux:select>
                                    </div>

                                    <div class="campo-filtro">
                                        <flux:select wire:key="field-operator-{{ $index }}"
                                            wire:model.live.debounce.500ms="filters.{{ $index }}.operator"
                                            placeholder="Operador">
                                            @foreach ($this->getGroupedOperators() as $group => $operators)
                                                <optgroup label="{{ $group }}">
                                                    @foreach ($operators as $operator)
                                                        <flux:select.option value="{{ $operator }}">
                                                            {{ $operator }}
                                                        </flux:select.option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </flux:select>
                                    </div>

                                    <div class="campo-filtro">
                                        <flux:input x-on:keydown.stop="" wire:key="field-value-{{ $index }}"
                                            wire:model.live.debounce.500ms="filters.{{ $index }}.value"
                                            placeholder="Valor" />
                                    </div>

                                    <flux:button wire:click="deleteFilter({{ $index }})" icon="x-mark"
                                        variant="ghost" class="boton-eliminar-fila" size="sm" />

                                </div>
                            @endforeach

                        </div>

                    </flux:menu>
                </flux:dropdown>
            @endif


        </div>

    </div>

    <div
        wire:loading.delay
        wire:target="search,per_page,sort,filters,addFilter,clearFilters,deleteFilter"
        class="w-full"
    >

        <flux:skeleton.group animate="shimmer">

            <flux:table>

                <flux:table.columns>

                    @foreach ($headers as $header)
                        <flux:table.column>{{ $header['label'] }}</flux:table.column>
                    @endforeach

                </flux:table.columns>

                <flux:table.rows>

                    @foreach (range(1, 5) as $order)
                        <flux:table.row>

                            @foreach ($headers as $header)
                                @if ($loop->first)
                                    <flux:table.cell>

                                        <div class="flex items-center gap-2">

                                            <flux:skeleton class="rounded-full size-5" />

                                            <div class="flex-1">

                                                <flux:skeleton.line style="width: {{ rand(50, 100) }}%" />

                                            </div>

                                        </div>

                                    </flux:table.cell>
                                @else
                                    <flux:table.cell>

                                        <flux:skeleton.line />

                                    </flux:table.cell>
                                @endif
                            @endforeach

                        </flux:table.row>
                    @endforeach

                </flux:table.rows>

            </flux:table>

        </flux:skeleton.group>

    </div>

    <div
        wire:loading.remove.delay
        wire:target="search,per_page,sort,filters,addFilter,clearFilters,deleteFilter"
    >

        <div class="lg:hidden">

            @forelse ($rows as $index => $rowData)

                <flux:card class="my-4">

                    <flux:table>

                        @if ($selectable)
                            <flux:table.rows>

                                <flux:table.cell align="start">

                                    <flux:checkbox wire:model.live="selectedRows" value="{{ $rowData->id }}" />

                                </flux:table.cell>

                            </flux:table.rows>
                        @endif

                        @foreach ($headers as $header)
                            <flux:table.rows class="even:bg-zinc-100 dark:even:bg-zinc-600">

                                @php

                                    $columnIndex = $header['index'];

                                    $slotKey = 'column_' . str_replace('.', '_', $columnIndex);

                                    $slot = $capturedSlots[$slotKey] ?? null;

                                @endphp

                                <flux:table.cell align="start">

                                    <span class="font-medium uppercase pl-4">

                                        {{ $header['label'] . ($header['index'] !== 'actions' ? ' :' : '') }}

                                    </span>

                                </flux:table.cell>

                                <flux:table.cell title="{{ data_get($rowData, $columnIndex, '') }}" align="end">

                                    <div class="pr-4">

                                        @if ($slot)
                                            @php

                                                try {
                                                    $result = $slot->call($this, $rowData, $loop ?? null);

                                                    echo $result instanceof HtmlString ? $result->toHtml() : $result;
                                                } catch (\Throwable $e) {
                                                    $context = ['row' => $rowData, 'loop' => $loop ?? null];

                                                    $result = app()->call($slot, $context);

                                                    echo $result instanceof HtmlString ? $result->toHtml() : $result;
                                                }

                                            @endphp
                                        @else
                                            {{ data_get($rowData, $columnIndex, '') }}
                                        @endif

                                    </div>

                                </flux:table.cell>

                            </flux:table.rows>
                        @endforeach

                    </flux:table>

                </flux:card>

            @empty

            @endforelse

            <flux:pagination :paginator="$rows" />

        </div>

        <div class="hidden lg:block">

            <flux:table :paginate="$rows">

                <flux:table.columns class="bg-white dark:bg-zinc-900">

                    @if ($selectable)
                        <flux:table.column>

                            <div class="flex items-center">

                                {{-- <flux:checkbox wire:change="selectedAllCurrentPage({{ json_encode($rows) }})" /> --}}

                            </div>

                        </flux:table.column>
                    @endif

                    <!-- sort by columnas -->
                    @foreach ($headers as $header)
                        <flux:table.column :sortable="$header['index'] !== 'actions'"
                            :sorted="$this->sortBy === $header['index']" :direction="$this->sortDirection"
                            wire:click="sort('{{ $header['index'] != 'actions' ? $header['index'] : '' }}')"
                            align="{{ $header['align'] ?? 'start' }}" width="{{ $header['width'] ?? null }}">

                            <span class="{{ $header['class'] ?? '' }} cursor-pointer">

                                {{ $header['label'] }}

                            </span>

                        </flux:table.column>
                    @endforeach

                </flux:table.columns>

                <flux:table.rows>

                    @forelse($rows as $index => $rowData)

                        <flux:table.row wire:key="{{ $rowData->id }}"
                            class="dark:hover:bg-neutral-700 hover:bg-neutral-100 text-neutral-600 dark:text-neutral-200">

                            @if ($selectable)
                                <flux:table.cell align="{{ $header['align'] ?? 'start' }}"
                                    width="{{ $header['width'] ?? null }}">

                                    <div class="flex items-center">

                                        <flux:checkbox wire:model.live="selectedRows" value="{{ $rowData->id }}" />

                                    </div>

                                </flux:table.cell>
                            @endif

                            @foreach ($headers as $header)
                                @php

                                    $columnIndex = $header['index'];

                                    $slotKey = 'column_' . str_replace('.', '_', $columnIndex);

                                    $slot = $capturedSlots[$slotKey] ?? null;

                                @endphp

                                <flux:table.cell title="{{ data_get($rowData, $columnIndex, '') }}"
                                    align="{{ $header['align'] ?? 'start' }}" width="{{ $header['width'] ?? null }}">

                                    @if ($slot)
                                        @php

                                            try {
                                                $result = $slot->call($this, $rowData, $loop ?? null);

                                                echo $result instanceof HtmlString ? $result->toHtml() : $result;
                                            } catch (\Throwable $e) {
                                                $context = ['row' => $rowData, 'loop' => $loop ?? null];

                                                $result = app()->call($slot, $context);

                                                echo $result instanceof HtmlString ? $result->toHtml() : $result;
                                            }

                                        @endphp
                                    @else
                                        {{ data_get($rowData, $columnIndex, '') }}
                                    @endif

                                </flux:table.cell>
                            @endforeach

                        </flux:table.row>

                    @empty

                        <flux:table.row>

                            <flux:table.cell align="center" colspan="{{ count($headers) }}">

                                No results found.

                            </flux:table.cell>

                        </flux:table.row>

                    @endforelse

                </flux:table.rows>

            </flux:table>

        </div>

    </div>

</div>

<style>
    /* Desplaza el encabezado y las celdas de la primera columna en escritorio. */
    @media (min-width: 1024px) {

        .tabla-asignadores table thead th:first-child,
        .tabla-asignadores table tbody td:first-child {
            padding-left: 30px !important;
        }
    }

    .menu-filtros-tabla {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        color: #334155 !important;
        min-width: 540px !important;
        max-width: calc(100vw - 24px) !important;
        padding: 0 !important;
        overflow: visible !important;
    }

    .panel-filtros {
        padding: 12px;
    }

    /* Botones superiores */
    .panel-filtros-acciones {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 12px;
    }

    .boton-agregar-filtro {
        background: #0284c7 !important;
        color: #ffffff !important;
        border-radius: 6px !important;
    }

    .boton-limpiar-filtro {
        background: #ef3340 !important;
        color: #ffffff !important;
        border-radius: 6px !important;
    }

    /* Campos de cada filtro */
    .fila-filtro {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) minmax(0, 0.85fr) 32px;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .campo-filtro {
        min-width: 0;
    }

    .boton-eliminar-fila {
        color: #ef3340 !important;
    }

    /* Adaptación móvil */
    @media (max-width: 640px) {
        .menu-filtros-tabla {
            min-width: 0 !important;
            width: calc(100vw - 24px) !important;
        }

        .fila-filtro {
            grid-template-columns: minmax(0, 1fr) 32px;
        }

        .campo-filtro {
            grid-column: 1;
        }

        .boton-eliminar-fila {
            grid-column: 2;
            grid-row: 1;
        }
    }

    .tabla-asignadores [data-flux-pagination] {
        padding: 16px 24px !important;
        min-height: 68px;
        box-sizing: border-box;
    }

    @media (max-width: 640px) {
        .tabla-asignadores [data-flux-pagination] {
            padding: 14px 16px !important;
            gap: 12px;
        }
    }


</style>
