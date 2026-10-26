
@props([
    'nombre' => 'modal-confirmacion',
    'titulo' => 'Confirmar acción',
    'mensaje' => '¿Está seguro de realizar esta acción?',
    'textoConfirmar' => 'Confirmar',
    'textoCancelar' => 'Cancelar',
    'color' => 'danger',
    'accion' => null,
])

<flux:modal :name="$nombre" class="w-full max-w-md">

    <div class="space-y-5">

        {{-- ENCABEZADO --}}
        <div class="flex items-start gap-4">

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl
                {{ $color === 'danger' ? 'bg-red-100' : 'bg-blue-100' }}">

                @if ($color === 'danger')
                    <flux:icon.exclamation-triangle
                        class="size-6 text-red-600" />
                @else
                    <flux:icon.question-mark-circle
                        class="size-6 text-blue-600" />
                @endif

            </div>

            <div class="min-w-0 flex-1">
                <flux:heading size="lg">
                    {{ $titulo }}
                </flux:heading>

                <flux:subheading class="mt-2">
                    {{ $mensaje }}
                </flux:subheading>
            </div>

        </div>

        {{-- BOTONES --}}
        <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">

            <flux:modal.close>
                <flux:button variant="ghost">
                    {{ $textoCancelar }}
                </flux:button>
            </flux:modal.close>

            <flux:button
                type="button"
                :variant="$color === 'danger' ? 'danger' : 'primary'"
                wire:click="{{ $accion }}"
                wire:loading.attr="disabled"
                wire:target="{{ $accion }}">

                {{ $textoConfirmar }}

            </flux:button>

        </div>

    </div>

</flux:modal>
