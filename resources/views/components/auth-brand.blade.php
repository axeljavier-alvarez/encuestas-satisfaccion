
@props([
    'title',
    'description',
])

<header class="mb-1 text-center">

    <!-- Logo: visible únicamente en escritorio -->
    <div class="mb-4 hidden justify-center lg:flex">
        <img
            src="{{ asset('images/icono_muni.png') }}"
            alt="Logo Municipalidad de Guatemala"
            class="h-auto w-[70px] object-contain"
        />
    </div>

    <!-- Título y logo responsive -->
    <div class="flex items-center justify-center gap-3 sm:gap-4">

        <!-- Título dinámico -->
        <h1 class="text-center text-xl font-bold leading-tight tracking-tight text-[#171f61] sm:text-2xl lg:text-[26px]">
            {{ $title }}
        </h1>

        <!-- Logo: visible solo en celular y tablet -->
        <img
            src="{{ asset('images/icono_muni.png') }}"
            alt="Logo Municipalidad de Guatemala"
            class="block h-auto w-12 shrink-0 object-contain sm:w-16 lg:hidden"
        />

    </div>

    <!-- Descripción dinámica -->
    <p class="mx-auto mt-3 max-w-[430px] text-sm leading-relaxed text-[#626a9e]">
        {{ $description }}
    </p>

</header>
