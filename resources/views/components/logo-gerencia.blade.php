
@props([
    'sidebar' => false,
])

@if ($sidebar)

    <flux:sidebar.brand
        name="Portal de Evaluaciones"
        {{ $attributes }}
    >
        <x-slot name="logo">
            <img
                src="{{ asset('images/logo-gerencia.png') }}"
                alt="Logo de la Gerencia"
                class="h-10 w-auto object-contain"
            />
        </x-slot>
    </flux:sidebar.brand>

@else

    <flux:brand
        name="Portal de Evaluaciones"
        {{ $attributes }}
    >
        <x-slot name="logo">
            <img
                src="{{ asset('images/logo-gerencia.png') }}"
                alt="Logo de la Gerencia"
                class="h-10 w-auto object-contain"
            />
        </x-slot>
    </flux:brand>

@endif
