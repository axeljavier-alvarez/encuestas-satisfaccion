<div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-6 sm:px-4">

    {{-- Encabezado institucional --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        {{-- Logo y título --}}
        <div class="flex items-center gap-4">
            <div class="flex h-20 w-20 shrink-0 items-center justify-center">
                <img src="{{ asset('images/icono_muni.png') }}"
                    alt="Municipalidad de Guatemala"
                    class="h-[75px] w-[75px] object-contain">
            </div>

            <div class="min-w-0">
                <flux:heading size="xl" level="1">
                    Asignadores
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    Administre los asignadores del sistema, sus puestos y permisos administrativos.
                </flux:text>
            </div>
        </div>
    </div>
</div>