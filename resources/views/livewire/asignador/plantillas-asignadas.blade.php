
<div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6">

    {{-- Encabezado --}}
    <div class="rounded-xl bg-white p-6 shadow-sm dark:bg-zinc-900">

        <flux:heading size="xl">
            Bienvenido, {{ auth()->user()->name }}
        </flux:heading>

        <flux:text class="mt-2">
            Desde este módulo podrás consultar tus plantillas
            asignadas y gestionar sus preguntas.
        </flux:text>

    </div>
</