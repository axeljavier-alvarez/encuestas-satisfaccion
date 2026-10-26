<x-layouts::auth :title="'Iniciar sesión'">
    <div class="flex flex-col gap-6">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.25em] text-blue-700">
                Acceso al sistema
            </p>

            <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">
                Iniciar sesión
            </h2>

            <p class="mt-3 text-sm leading-6 text-slate-500">
                Ingrese su correo electrónico y contraseña para consultar
                las evaluaciones que tiene asignadas.
            </p>
        </div>

        {{-- Mensajes del sistema --}}
        <x-auth-session-status
            class="text-center"
            :status="session('status')"
        />

        <form
            method="POST"
            action="{{ route('login.store') }}"
            class="flex flex-col gap-5"
        >
            @csrf

            {{-- Correo electrónico --}}
            <flux:input
                name="email"
                label="Correo electrónico"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="usuario@empresa.com"
            />

            {{-- Contraseña --}}
            <flux:input
                name="password"
                label="Contraseña"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Ingrese su contraseña"
                viewable
            />

            {{-- Recordar sesión --}}
            <flux:checkbox
                name="remember"
                label="Recordar mi sesión"
                :checked="old('remember')"
            />

            <flux:button
                variant="primary"
                type="submit"
                class="w-full"
                data-test="login-button"
            >
                Ingresar al portal
            </flux:button>
        </form>

        
    </div>
</x-layouts::auth>