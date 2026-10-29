<x-layouts::auth :title="'Iniciar sesión'">

    <div class="flex flex-col gap-6">

        <!-- Encabezado reutilizable -->
        <x-auth-brand title="Encuestas de satisfacción"
            description="Plataforma para realizar evaluaciones de desempeño de forma sencilla, organizada y confidencial." />

        <!-- Título -->
        {{-- <h2 class="text-base font-semibold text-[#171f61]">
            Iniciar sesión
        </h2> --}}

        <!-- Mensajes del sistema -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <!-- Formulario -->
        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Correo -->
            <x-auth-input name="email" type="email" icon="user" placeholder="Correo electrónico"
                autocomplete="email" required autofocus />

            <!-- Contraseña -->
            <x-auth-input name="password" type="password" icon="lock" placeholder="Contraseña"
                autocomplete="current-password" required />

            <!-- Opciones -->
            <div class="flex flex-wrap items-center justify-between gap-3">

                <label class="flex items-center gap-2 text-sm text-[#626a9e]">

                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 accent-[#273385]"
                        @checked(old('remember', false)) />

                    Recordarme

                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-[#626a9e] hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

            </div>

            <!-- Botón -->
            <div class="pt-5 text-center">

                <button type="submit"
                    class="inline-flex h-12 min-w-[185px] items-center justify-center rounded-sm bg-[#273385] px-8 font-semibold text-white hover:bg-[#1b2566]"
                    data-test="login-button">
                    Iniciar sesión
                </button>

                @if (Route::has('register'))
                    <p class="mt-5 text-sm text-[#626a9e]">

                        ¿No tienes cuenta?

                        <a href="{{ route('register') }}" class="hover:underline">
                            Regístrate
                        </a>

                    </p>
                @endif

            </div>

        </form>

    </div>

</x-layouts::auth>
