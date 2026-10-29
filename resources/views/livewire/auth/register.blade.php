
<x-layouts::auth :title="'Registrarse'">

    <div class="flex flex-col gap-6">

        <!-- Encabezado -->
        <x-auth-header
            title="Crear una cuenta"
            description="Ingresa tus datos a continuación para crear tu cuenta"
        />

        <!-- Estado de sesión -->
        <x-auth-session-status
            class="text-center"
            :status="session('status')"
        />

        <form
            method="POST"
            action="{{ route('register.store') }}"
            class="flex flex-col gap-6"
        >
            @csrf

            <!-- Nombre completo -->
            <flux:input
                name="name"
                label="Nombre completo"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="Ingresa tu nombre completo"
            />

            <!-- Correo electrónico -->
            <flux:input
                name="email"
                label="Correo electrónico"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="correo@ejemplo.com"
            />

            <!-- Contraseña -->
            <flux:input
                name="password"
                label="Contraseña"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Ingresa tu contraseña"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <!-- Confirmar contraseña -->
            <flux:input
                name="password_confirmation"
                label="Confirmar contraseña"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Confirma tu contraseña"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <!-- Botón de registro -->
            <div class="flex items-center justify-end">

                <flux:button
                    type="submit"
                    variant="primary"
                    class="w-full"
                    data-test="register-user-button"
                >
                    Crear cuenta
                </flux:button>

            </div>

        </form>

        <!-- Enlace para iniciar sesión -->
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">

            <span>¿Ya tienes una cuenta?</span>

            <flux:link :href="route('login')" wire:navigate>
                Iniciar sesión
            </flux:link>

        </div>

    </div>

</x-layouts::auth>
