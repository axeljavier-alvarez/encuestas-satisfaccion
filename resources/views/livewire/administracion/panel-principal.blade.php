<div class="space-y-6">

    {{-- Encabezado --}}
    <div class="flex items-center gap-4">
        {{-- Ícono institucional --}}
        <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('images/icono_muni.png') }}" alt="Municipalidad de Guatemala"
                class="h-[75px] w-[75px] object-contain" />
        </div>
        {{-- Título y descripción --}}
        <div class="min-w-0">
            <flux:heading size="xl" level="1" class="font-bold">
                Panel principal
            </flux:heading>

            <flux:text class="mt-1 text-sm">
                Resumen general del Portal de Encuestas de Satisfacción.
            </flux:text>
        </div>
    </div>

    {{-- Indicadores --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Plantillas --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total de plantillas
                    </p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ number_format($totalPlantillas) }}
                    </p>
                </div>
                <div class="rounded-xl bg-blue-50 p-3 text-blue-700">
                    <flux:icon.document-text class="size-6" />
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">
                Plantillas registradas
            </p>
        </div>

        {{-- Usuarios --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Usuarios registrados
                    </p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ number_format($totalUsuarios) }}
                    </p>
                </div>
                <div class="rounded-xl bg-violet-50 p-3 text-violet-700">
                    <flux:icon.users class="size-6" />
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">
                Usuarios del sistema
            </p>
        </div>

        {{-- Preguntas activas --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Preguntas activas
                    </p>
                    <p class="mt-3 text-3xl font-bold text-emerald-700">
                        {{ number_format($preguntasActivas) }}
                    </p>
                </div>
                <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                    <flux:icon.check-circle class="size-6" />
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">
                Disponibles para utilizar
            </p>
        </div>

        {{-- Preguntas inactivas --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Preguntas inactivas
                    </p>
                    <p class="mt-3 text-3xl font-bold text-red-600">
                        {{ number_format($preguntasInactivas) }}
                    </p>
                </div>
                <div class="rounded-xl bg-red-50 p-3 text-red-600">
                    <flux:icon.x-circle class="size-6" />
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">
                No disponibles actualmente
            </p>
        </div>

    </div>

    {{-- Información del portal --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <flux:heading size="lg">
            Portal de Encuestas de Satisfacción
        </flux:heading>

        <flux:text class="mt-2">
            Plataforma para la administración de plantillas,
            gestión del banco de preguntas y seguimiento
            de encuestas de satisfacción.
        </flux:text>
    </div>

</div>
