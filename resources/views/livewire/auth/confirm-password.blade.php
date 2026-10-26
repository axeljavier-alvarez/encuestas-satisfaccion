<x-layouts::auth :title="'Confirmar contraseña'">
    <div class="flex flex-col gap-6">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.25em] text-blue-700">
                Área segura
            </p>

            <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">
                Confirmar contraseña
            </h2>

            <p class="mt-3 text-sm leading-6 text-slate-500">
                Esta es un área protegida del sistema. Ingrese nuevamente su
                contraseña para continuar.
            </p>
        </div>

        <form
            method="POST"
            action="{{ route('password.confirm.store') }}"
            class="flex flex-col gap-5"
        >
            @csrf

            <flux:input
                name="password"
                label="Contraseña"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Ingrese su contraseña"
                viewable
            />

            <flux:button
                variant="primary"
                type="submit"
                class="w-full"
            >
                Continuar
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
