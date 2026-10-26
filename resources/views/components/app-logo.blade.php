@props([
    'sidebar' => false,
])

@if ($sidebar)
    <flux:sidebar.header>
        <div class="flex w-full items-center justify-center px-2 py-3">
            <img
                src="{{ asset('images/logo_gerencia.png') }}"
                alt="Gerencia de Desarrollo Social"
                class="block h-auto w-full max-w-[180px] object-contain"
            />
        </div>

        <flux:sidebar.collapse class="lg:hidden" />
    </flux:sidebar.header>
@else
    <flux:brand name="Portal de Evaluaciones" {{ $attributes }}>
        <x-slot name="logo"
            class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
        </x-slot>
    </flux:brand>
@endif