<div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-6 sm:px-4">

    {{-- ENCABEZADO INSTITUCIONAL --}}

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex items-center gap-4">

            {{-- ÍCONO ASIGNADORES --}}
            <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-blue-50">
                <flux:icon.users class="size-10 text-blue-700" />
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
    <x-alerta />

    {{-- PANEL PRINCIPAL --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
        <div class="border-t border-zinc-200"></div>
        {{-- TABLA RESPONSIVA --}}
        <x-data-table :headers="$headers" :rows="$this->rows" :advance-filter="true"
            empty-message="No se encontraron asignadores.">

            {{-- ROL --}}
            @interact('id', $row)
                {{ $row->id }}
            @endinteract

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
                <flux:badge :color="$row->activo == 1 ? 'green' : 'red'" size="sm">
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
                            Acciones del asignador
                        </flux:menu.item>

                        <flux:menu.separator />

                        <flux:menu.item icon="pencil-square" wire:click="editar({{ $row->id }})">
                            Editar usuario
                        </flux:menu.item>
                        <flux:menu.separator />
                        <flux:menu.item :icon="$row->activo ? 'no-symbol' : 'check-circle'"
                            :variant="$row->activo ? 'danger' : 'default'"
                            wire:click="confirmarCambioEstado({{ $row->id }})">
                            {{ $row->activo ? 'Desactivar usuario' : 'Activar usuario' }}
                        </flux:menu.item>
                    </flux:menu>

                </flux:dropdown>
            @endinteract

        </x-data-table>

    </div>

    {{-- MODAL NUEVO ASIGNADOR --}}

    <flux:modal name="nuevo-asignador" class="w-full max-w-lg" @close="resetData">
        <div class="space-y-6">

            {{-- ENCABEZADO --}}
            <div>
                <flux:heading size="xl">
                    {{ $asignadorId ? 'Editar asignador' : 'Nuevo asignador' }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ $asignadorId
                        ? 'Actualice la información del usuario asignador.'
                        : 'Complete la información para registrar un nuevo usuario asignador.' }}
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
                <flux:input wire:model="password" type="password"
                    :label="$asignadorId ? 'Nueva contraseña' : 'Contraseña'" placeholder="Mínimo 8 caracteres"
                    viewable />

                {{-- CONFIRMAR CONTRASEÑA --}}
                <flux:input wire:model="password_confirmation" type="password" label="Confirmar contraseña"
                    placeholder="Repita la contraseña" viewable />

                {{-- MENSAJE AL EDITAR --}}
                @if ($asignadorId)
                    <p class="text-xs text-zinc-500">
                        Deje los campos de contraseña vacíos
                        si no desea modificarla.
                    </p>
                @endif

                {{-- BOTONES --}}
                <div class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end">

                    <flux:button type="button" variant="ghost" wire:click="cerrarModal">
                        Cancelar
                    </flux:button>

                    <flux:button type="submit" variant="primary" icon="check" wire:loading.attr="disabled"
                        wire:target="guardar">
                        {{ $asignadorId ? 'Guardar cambios' : 'Guardar asignador' }}
                    </flux:button>

                </div>

            </form>

        </div>
    </flux:modal>

    <x-confirmacion nombre="confirmar-estado-asignador" :titulo="$nuevoEstadoAsignador ? 'Activar asignador' : 'Desactivar asignador'" :mensaje="$nuevoEstadoAsignador
        ? '¿Está seguro de que desea activar al asignador ' . $nombreAsignadorEstado . '?'
        : '¿Está seguro de que desea desactivar al asignador ' . $nombreAsignadorEstado . '?'" :texto-confirmar="$nuevoEstadoAsignador ? 'Sí, activar' : 'Sí, desactivar'"
        :color="$nuevoEstadoAsignador ? 'primary' : 'danger'" accion="cambiarEstadoAsignador" />

</div>
