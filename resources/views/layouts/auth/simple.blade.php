
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-[#273385] antialiased">

    <div class="relative flex min-h-screen min-h-[100dvh]
                items-center justify-center overflow-hidden
                px-4 py-6 lg:px-8">

        <!-- Decoraciones del fondo -->
        <div class="pointer-events-none absolute -left-28 -top-36
                    h-56 w-56 rounded-full bg-[#6572bd]"></div>

        <div class="pointer-events-none absolute -right-24 -top-48
                    h-80 w-80 rounded-full bg-[#6572bd]"></div>

        <div class="pointer-events-none absolute -bottom-32 -left-44
                    h-56 w-56 rounded-full bg-[#6572bd]"></div>

        <div class="pointer-events-none absolute -bottom-48 -right-24
                    h-72 w-72 rounded-full bg-[#6572bd]"></div>

        <!-- Contenedor blanco -->
        <main class="relative z-10 flex w-full max-w-[1250px]
                     flex-col justify-center bg-[#f8f8f8]
                     px-6 py-9 shadow-sm
                     sm:px-10 lg:min-h-[550px]
                     lg:px-16 lg:py-12 xl:px-20">

            <div class="grid w-full grid-cols-1 items-center
                        gap-8 lg:grid-cols-2 lg:gap-12 xl:gap-16">

                <!-- Ilustración -->
                <div class="order-1 flex items-center justify-center">

                    <img
                        src="{{ asset('images/encuestas_satisfaccion.png') }}"
                        alt="Ilustración de encuestas de satisfacción"
                        class="h-auto w-full max-w-[220px]
                               object-contain sm:max-w-[350px]
                               lg:max-w-[480px]"
                    />

                </div>

                <!-- Formulario de autenticación -->
                <section class="order-2 mx-auto w-full max-w-[480px]">

                    {{ $slot }}

                </section>

            </div>

        </main>

    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts

</body>
</html>
