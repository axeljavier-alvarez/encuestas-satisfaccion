<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-slate-800 antialiased">
        <main class="flex min-h-screen items-center justify-center px-6 py-10">
            <section class="grid w-full max-w-6xl overflow-hidden rounded-3xl bg-white shadow-2xl lg:grid-cols-[1.1fr_0.9fr]">

                {{-- Panel institucional --}}
                <div class="relative hidden overflow-hidden bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-950 p-10 text-white lg:block">
                    <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-blue-400/20 blur-3xl"></div>
                    <div class="absolute -bottom-20 -right-20 h-80 w-80 rounded-full bg-cyan-400/20 blur-3xl"></div>

                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <div>
                            <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 shadow-lg ring-1 ring-white/20 backdrop-blur">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8 text-cyan-200"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"
                                    />
                                </svg>                            </div>

                            <h1 class="mt-8 text-4xl font-black tracking-tight">
                                Portal de Evaluaciones
                            </h1>

                            <p class="mt-4 max-w-md text-sm leading-7 text-blue-100">
                                Plataforma para realizar evaluaciones de desempeño de forma
                                sencilla, organizada y confidencial.
                            </p>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10 backdrop-blur">
                                <p class="text-2xl font-black">
                                   {{ \App\Models\Plantilla::where('activo', true)->count() }}
                                </p>

                               <p class="mt-1 text-xs text-blue-100">
                                  Plantillas
                               </p>
                            </div>

                            <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10 backdrop-blur">
                                <p class="text-2xl font-black">180°</p>
                                <p class="mt-1 text-xs text-blue-100">Evaluación</p>
                            </div>

                            <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10 backdrop-blur">
                                <p class="text-2xl font-black">100%</p>
                                <p class="mt-1 text-xs text-blue-100">Web</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Panel para el formulario --}}
                <div class="p-8 sm:p-10 lg:p-12">
                    <div class="mx-auto flex h-full max-w-md flex-col justify-center">
                        <div class="lg:hidden">
                            <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-700 text-white shadow-lg shadow-blue-700/20">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>
                        </div>

                        {{ $slot }}
                    </div>
                </div>
            </section>
        </main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
