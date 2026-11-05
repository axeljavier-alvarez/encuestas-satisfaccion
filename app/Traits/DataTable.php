<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\WithPagination;

trait DataTable
{
    use WithPagination;

    // Búsqueda, paginación y ordenamiento
    public string $search = '';
    public string $sortBy = 'id';
    public string $sortDirection = 'desc';
    public int $per_page = 10;

    // Filtros y selección
    public array $filters = [];
    public array $selectedRows = [];

    protected array $numericOperators = [
        '=', '!=', '>', '<', '>=', '<='
    ];

    protected array $stringOperators = [
        'like', 'not like'
    ];

    protected array $arrayOperators = [
        'between', 'not between', 'in', 'not in'
    ];

    protected array $nullOperators = [
        'null', 'not null'
    ];

    // Inicializar filtros
    public function initializeDataTable(): void
    {
        if (empty($this->filters)) {
            $this->filters = [
                ['field' => '', 'operator' => '', 'value' => '']
            ];
        }
    }

    // Columnas que admite cada módulo
    protected function tableSortableColumns(): array
    {
        return ['id'];
    }

    protected function tableFilterableColumns(): array
    {
        return $this->tableSortableColumns();
    }

    // Ordenamiento
    public function sort(string $column): void
    {
        if (!in_array(
            $column,
            $this->tableSortableColumns(),
            true
        )) {
            return;
        }

        if ($this->sortBy === $column) {
            $this->sortDirection =
                $this->sortDirection === 'asc'
                    ? 'desc'
                    : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    // Cantidad de registros
    protected function getPerPage(): int
    {
        $permitidos = [
            5, 10, 20, 50, 100, 500, 1000
        ];

        return in_array($this->per_page, $permitidos, true)
            ? $this->per_page
            : 10;
    }

    // Aplicar ordenamiento a la consulta
    protected function applyTableSorting(Builder $query): Builder
    {
        $column = in_array(
            $this->sortBy,
            $this->tableSortableColumns(),
            true
        ) ? $this->sortBy : 'id';

        $direction = in_array(
            $this->sortDirection,
            ['asc', 'desc'],
            true
        ) ? $this->sortDirection : 'asc';

        return $query->orderBy($column, $direction);
    }

    // Agregar filtro
    public function addFilter(): void
    {
        $this->filters[] = [
            'field' => '',
            'operator' => '',
            'value' => ''
        ];
    }

    // Eliminar filtro
    public function deleteFilter(int $index): void
    {
        if (!array_key_exists($index, $this->filters)) {
            return;
        }

        unset($this->filters[$index]);

        $this->filters = array_values($this->filters);

        if (empty($this->filters)) {
            $this->clearFilters();
        }

        $this->resetPage();
    }

    // Limpiar filtros
    public function clearFilters(): void
    {
        $this->filters = [
            ['field' => '', 'operator' => '', 'value' => '']
        ];

        $this->resetPage();
    }

    // Operadores agrupados
    public function getGroupedOperators(): array
    {
        return [
            'Comparación' => $this->numericOperators,
            'Texto' => $this->stringOperators,
            'Array' => $this->arrayOperators,
            'Nulos' => $this->nullOperators,
        ];
    }

    public function getAvailableOperators(): array
    {
        return array_merge(
            $this->numericOperators,
            $this->stringOperators,
            $this->arrayOperators,
            $this->nullOperators
        );
    }

    public function getAvailableFields(): array
    {
        return $this->tableFilterableColumns();
    }

    public function getActiveFiltersCount(): int
    {
        return count(array_filter(
            $this->filters,
            fn ($filter) =>
                !empty($filter['field']) &&
                !empty($filter['operator'])
        ));
    }

    // Preparar filtros
    protected function processFilters(): array
    {
        return collect($this->filters)
            ->filter(function ($filter) {
                return !empty($filter['field'])
                    && !empty($filter['operator']);
            })
            ->map(function ($filter) {
                $operator = strtolower($filter['operator']);
                $value = $filter['value'] ?? '';

                if (
                    in_array($operator, $this->arrayOperators, true)
                    && is_string($value)
                    && $value !== ''
                ) {
                    $filter['value'] = $this->convertToArray($value);
                }

                if (in_array($operator, $this->nullOperators, true)) {
                    $filter['value'] = null;
                }

                if (
                    in_array($operator, $this->stringOperators, true)
                    && is_string($value)
                    && $value !== ''
                    && !Str::contains($value, '%')
                ) {
                    $filter['value'] = "%{$value}%";
                }

                return $filter;
            })
            ->values()
            ->toArray();
    }

    protected function convertToArray(string $value): array
    {
        return collect(explode(',', $value))
            ->map(fn ($item) => trim($item))
            ->filter(fn ($item) => $item !== '')
            ->map(function ($item) {
                if (is_numeric($item)) {
                    return str_contains($item, '.')
                        ? (float) $item
                        : (int) $item;
                }

                $lower = strtolower($item);

                return match ($lower) {
                    'true' => true,
                    'false' => false,
                    'null' => null,
                    default => $item,
                };
            })
            ->values()
            ->toArray();
    }

    // Aplicar filtros a Eloquent
    protected function applyTableFilters(Builder $query): Builder
    {
        $columns = $this->tableFilterableColumns();

        foreach ($this->processFilters() as $filter) {
            $field = $filter['field'];
            $operator = strtolower($filter['operator']);
            $value = $filter['value'];

            if (!in_array($field, $columns, true)) {
                continue;
            }

            if (!in_array(
                $operator,
                $this->getAvailableOperators(),
                true
            )) {
                continue;
            }

            if ($operator === 'null') {
                $query->whereNull($field);
                continue;
            }

            if ($operator === 'not null') {
                $query->whereNotNull($field);
                continue;
            }

            if (in_array($operator, ['between', 'not between'], true)) {
                if (!is_array($value) || count($value) !== 2) {
                    continue;
                }

                if ($operator === 'between') {
                    $query->whereBetween($field, $value);
                } else {
                    $query->whereNotBetween($field, $value);
                }

                continue;
            }

            if (in_array($operator, ['in', 'not in'], true)) {
                if (!is_array($value) || empty($value)) {
                    continue;
                }

                if ($operator === 'in') {
                    $query->whereIn($field, $value);
                } else {
                    $query->whereNotIn($field, $value);
                }

                continue;
            }

            if ($value === '' || $value === null) {
                continue;
            }

            $query->where($field, $operator, $value);
        }

        return $query;
    }

    // Reiniciar paginación
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function updatingFilters(): void
    {
        $this->resetPage();
    }
}
