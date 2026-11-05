<div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-6 sm:px-4">

    {{-- ENCABEZADO INSTITUCIONAL --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex items-center gap-4">

            <div class="flex h-20 w-20 shrink-0 items-center justify-center">
                <img src="{{ asset('images/icono_muni.png') }}" alt="Municipalidad de Guatemala"
                    class="h-[75px] w-[75px] object-contain">
            </div>

            <div class="min-w-0">
                <flux:heading size="xl" level="1">
                    Asignadores
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    Administre los usuarios encargados de gestionar
                    las plantillas de encuestas asignadas.
                </flux:text>
            </div>

        </div>

        <div class="flex flex-wrap items-center gap-3">

            <flux:badge color="blue" size="lg">
                {{ $totalAsignadores }} asignadores
            </flux:badge>

            <flux:button variant="primary" icon="plus" wire:click="crear">
                Nuevo asignador
            </flux:button>

        </div>

    </div>

    {{-- MENSAJE DE CONFIRMACIÓN --}}
    @if (session()->has('mensaje'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- PANEL PRINCIPAL --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
        <div class="border-t border-zinc-200"></div>
        {{-- TABLA RESPONSIVA --}}
        <x-data-table :$headers :$rows empty-message="No se encontraron asignadores.">

            {{-- ASIGNADOR --}}
            @interact('name', $row)
                <div class="flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-50 font-semibold text-blue-800">
                        {{ $row->initials() }}
                    </div>

                    <div class="min-w-0">

                        <p class="font-semibold text-zinc-900">
                            {{ $row->name }}
                        </p>

                        <p class="mt-1 break-all text-xs text-zinc-500">
                            {{ $row->email }}
                        </p>

                    </div>

                </div>
            @endinteract

            {{-- ROL --}}
            @interact('rol', $row)
                <flux:badge color="blue" size="sm">
                    {{ ucfirst($row->rol) }}
                </flux:badge>
            @endinteract

             {{-- Estado --}}
            @interact('activo', $row)
                <flux:badge
                    :color="$row->activo == 1 ? 'green' : 'red'"
                    size="sm"
                >
                    {{ $row->activo == 1 ? 'Activo' : 'Inactivo' }}
                </flux:badge>
            @endinteract


            {{-- PLANTILLAS ASIGNADAS --}}
            @interact('plantillas_count', $row)
                <span
                    class="inline-flex min-w-10 items-center justify-center rounded-lg bg-blue-50 px-3 py-2 font-semibold text-blue-900">
                    {{ $row->plantillas_count }}
                </span>
            @endinteract

            {{-- ACCIONES --}}
            @interact('actions', $row)
                <flux:dropdown position="bottom" align="end">

                    <flux:button icon="ellipsis-vertical" variant="ghost" size="sm" aria-label="Acciones" />

                    <flux:menu>

                        <flux:menu.item disabled>
                            Próximamente
                        </flux:menu.item>

                    </flux:menu>

                </flux:dropdown>
            @endinteract

        </x-data-table>

    </div>

    {{-- MODAL NUEVO ASIGNADOR --}}
    <flux:modal name="nuevo-asignador" class="w-full max-w-lg" @close="resetData">

        <div class="space-y-6">

            {{-- ENCABEZADO DEL MODAL --}}
            <div>
                <flux:heading size="xl">
                    Nuevo asignador
                </flux:heading>

                <flux:text class="mt-2">
                    Complete la información para registrar
                    un nuevo usuario asignador.
                </flux:text>
            </div>

            {{-- FORMULARIO --}}
            <form wire:submit="guardar" class="space-y-5">

                {{-- NOMBRE --}}
                <flux:input wire:model="nombre" label="Nombre completo" placeholder="Ingrese el nombre completo"
                    icon="user" required />

                {{-- CORREO --}}
                <flux:input wire:model="email" label="Correo electrónico" type="email"
                    placeholder="correo@ejemplo.com" icon="envelope" required />

                {{-- CONTRASEÑA --}}
                <flux:input wire:model="password" label="Contraseña" type="password" placeholder="Mínimo 8 caracteres"
                    viewable required />

                {{-- CONFIRMAR CONTRASEÑA --}}
                <flux:input wire:model="password_confirmation" label="Confirmar contraseña" type="password"
                    placeholder="Repita la contraseña" viewable required />

                {{-- BOTONES --}}
                <div class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end">

                    <flux:button type="button" variant="ghost" wire:click="cerrarModal">
                        Cancelar
                    </flux:button>

                    <flux:button type="submit" variant="primary" icon="check" wire:loading.attr="disabled"
                        wire:target="guardar">
                        Guardar asignador
                    </flux:button>

                </div>

            </form>

        </div>

    </flux:modal>

</div>
