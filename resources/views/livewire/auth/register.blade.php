<x-layouts::auth :title="'Registrarse'">

    <div class="flex flex-col gap-6">

        <!-- Encabezado -->
        <x-auth-brand title="Crear una cuenta" description="Ingrese sus datos a continuación para crear su cuenta" />

        <!-- Estado de sesión -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <!-- Formulario -->
        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Nombre completo -->
            <x-auth-input name="name" type="text" icon="user" placeholder="Nombre completo" autocomplete="name"
                required autofocus />

            <!-- Correo electrónico -->
            <x-auth-input name="email" type="email" icon="mail" placeholder="Correo electrónico"
                autocomplete="email" required />

            <!-- Contraseña -->
            <x-auth-input name="password" type="password" icon="lock" placeholder="Contraseña"
                autocomplete="new-password" required />

            <!-- Confirmar contraseña -->
            <x-auth-input name="password_confirmation" type="password" icon="lock" placeholder="Confirmar contraseña"
                autocomplete="new-password" required />

            <!-- Botón de registro -->
            <div class="flex items-center justify-end">

                {{-- <flux:button
                    type="submit"
                    variant="municipal"
                    class="w-full"
                    data-test="register-user-button"
                >
                    Crear cuenta
                </flux:button> --}}
                <button type="submit"
                    class="inline-flex h-12 w-full items-center justify-center rounded-sm bg-[#273385] px-8 font-semibold text-white hover:bg-[#1b2566]"
                    data-test="register-user-button">
                    Crear cuenta
                </button>
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
