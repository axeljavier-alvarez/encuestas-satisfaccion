<div class="mx-auto w-full max-w-7xl px-2 sm:px-4 space-y-4">

    {{-- Encabezado --}}
    <div
        class="overflow-hidden rounded-2xl bg-gradient-to-r from-slate-950 via-blue-950 to-indigo-900 px-6 py-4 text-white shadow-lg">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-blue-200">
                    Asistente
                </p>

                <h1 class="mt-1.5 text-2xl font-black tracking-tight">
                    Preguntas
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-5 text-blue-100">
                    Gestione las preguntas de evaluación agrupadas por factores y temas.
                </p>

            </div>


            <flux:button wire:click="crear" variant="primary"
                class="w-fit bg-white text-xs font-black text-blue-900 hover:bg-blue-50">
                + Nueva pregunta
            </flux:button>

        </div>
    </div>


    {{-- Mensaje --}}
    @if (session('mensaje'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800">
            {{ session('mensaje') }}
        </div>
    @endif


    {{-- Contenedor principal --}}
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 space-y-4">

        <div class="flex flex-col gap-3 border-b border-slate-200 pb-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-700">
                    Banco de reactivos
                </p>

                <h2 class="mt-1 text-xl font-black tracking-tight text-slate-950">
                    Listado de preguntas
                </h2>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Puede buscar por contenido y crear o editar preguntas.
                </p>

            </div>


            <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">

                {{-- Filtro NPS --}}
                <div class="w-full sm:w-52">

                    <flux:select wire:model.live="filtroNps">

                        <option value="todos">
                            Todas las preguntas
                        </option>

                        <option value="nps">
                            Solo NPS
                        </option>

                        <option value="no_nps">
                            No NPS
                        </option>

                    </flux:select>

                </div>


                {{-- Buscar --}}
                <div class="w-full sm:w-80">

                    <flux:input wire:model.live.debounce.300ms="buscar" placeholder="Buscar pregunta..."
                        icon="magnifying-glass" clearable />

                </div>

            </div>

        </div>


        {{-- Tabla --}}
        <flux:table :paginate="$preguntas">

            <flux:table.columns>
                <flux:table.column class="text-center">
                    ID
                </flux:table.column>

                <flux:table.column>
                    Pregunta
                </flux:table.column>

                <flux:table.column>
                    Factor
                </flux:table.column>

                <flux:table.column>
                    Tema / Aspecto
                </flux:table.column>

                <flux:table.column>
                    Tipo
                </flux:table.column>

                <flux:table.column class="text-center">
                    Estado
                </flux:table.column>

                <flux:table.column class="text-end">
                    Acciones
                </flux:table.column>

            </flux:table.columns>


            <flux:table.rows>

                @forelse ($preguntas as $pregunta)
                    <flux:table.row wire:key="pregunta-{{ $pregunta->id }}">

                        <flux:table.cell class="text-center">

                            <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-black text-slate-700">
                                #{{ $pregunta->id }}
                            </span>

                        </flux:table.cell>


                        {{-- Pregunta --}}
                        <flux:table.cell>

                            <div class="flex items-center gap-2">

                                <p class="text-sm font-bold text-slate-900">
                                    {{ $pregunta->texto }}
                                </p>


                                @if ($pregunta->es_nps)
                                    <flux:badge variant="pill" color="violet" size="sm">
                                        NPS
                                    </flux:badge>
                                @endif

                            </div>

                        </flux:table.cell>


                        {{-- Factor --}}
                        <flux:table.cell>

                            <span class="text-xs font-semibold text-blue-700">
                                {{ $pregunta->factor->nombre ?? 'Sin factor' }}
                            </span>

                        </flux:table.cell>


                        {{-- Tema --}}
                        <flux:table.cell>

                            @if ($pregunta->tema)
                                <span class="text-xs font-semibold text-slate-700">
                                    {{ $pregunta->tema->nombre }}
                                </span>
                            @else
                                <span class="text-xs italic text-slate-400">
                                    Sin tema o aspecto
                                </span>
                            @endif

                        </flux:table.cell>


                        {{-- Tipo --}}
                        <flux:table.cell>

                            <flux:badge variant="pill" size="sm">

                                @switch($pregunta->tipo)
                                    @case('texto')
                                        Texto libre
                                    @break

                                    @case('si_no')
                                        Sí / No
                                    @break

                                    @case('escala')
                                        Escala
                                    @break

                                    @case('seleccion_multiple')
                                        Selección múltiple
                                    @break

                                    @case('nps')
                                        NPS
                                    @break

                                    @default
                                        {{ $pregunta->tipo }}
                                @endswitch

                            </flux:badge>

                        </flux:table.cell>


                        {{-- Estado --}}
                        <flux:table.cell class="text-center">

                            <flux:badge variant="pill" :color="$pregunta->activo ? 'emerald' : 'zinc'" size="sm">
                                {{ $pregunta->activo ? 'Activo' : 'Inactivo' }}
                            </flux:badge>

                        </flux:table.cell>


                        {{-- Acciones --}}
                        <flux:table.cell class="text-end">

                            <flux:button size="sm" variant="subtle" wire:click="editar({{ $pregunta->id }})">
                                Editar
                            </flux:button>

                        </flux:table.cell>

                    </flux:table.row>
                    @empty

                        <flux:table.row>

                            <flux:table.cell colspan="6" class="py-8 text-center">

                                <p class="text-sm font-black text-slate-700">
                                    No se encontraron preguntas
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Cambie el texto de búsqueda o registre una nueva pregunta.
                                </p>

                            </flux:table.cell>

                        </flux:table.row>
                    @endforelse

                </flux:table.rows>

            </flux:table>

        </div>


        {{-- Modal --}}
        <flux:modal wire:model="mostrarModal" class="max-w-lg space-y-6">

            <div>

                <flux:heading size="lg">
                    {{ $preguntaId ? 'Editar pregunta' : 'Nueva pregunta' }}
                </flux:heading>

                <flux:subheading>
                    Banco de reactivos
                </flux:subheading>

            </div>


            <form wire:submit="guardar" class="space-y-4">

                {{-- Factor --}}
                <flux:select wire:model.live="factorId" label="Factor">

                    <option value="">
                        Seleccione un factor
                    </option>

                    @foreach ($factores as $factor)
                        <option value="{{ $factor->id }}">
                            {{ $factor->nombre }}
                        </option>
                    @endforeach

                </flux:select>

                @error('factorId')
                    <p class="text-xs font-bold text-red-600">
                        {{ $message }}
                    </p>
                @enderror


                {{-- Tema / Aspecto --}}
                <flux:select wire:model="temaId" label="Tema / Aspecto" :disabled="!$factorId">

                    <option value="">
                        Sin tema o aspecto
                    </option>

                    @foreach ($temas as $tema)
                        <option value="{{ $tema->id }}">
                            {{ $tema->nombre }}
                        </option>
                    @endforeach

                </flux:select>

                @error('temaId')
                    <p class="text-xs font-bold text-red-600">
                        {{ $message }}
                    </p>
                @enderror


                {{-- Tipo --}}
                <flux:select wire:model.live="tipo" label="Tipo de pregunta" :disabled="!$factorId">

                    <option value="texto">
                        Texto libre
                    </option>

                    <option value="si_no">
                        Sí / No
                    </option>

                    <option value="escala">
                        Escala
                    </option>

                    <option value="seleccion_multiple">
                        Selección múltiple
                    </option>

                    <option value="nps">
                        NPS
                    </option>

                </flux:select>

                @error('tipo')
                    <p class="text-xs font-bold text-red-600">
                        {{ $message }}
                    </p>
                @enderror


                {{-- Opciones --}}
                @if (in_array($tipo, ['escala', 'seleccion_multiple']))
                    <flux:input wire:model="opciones" label="Opciones (separadas por coma)"
                        placeholder="Opción 1, Opción 2, Opción 3" :disabled="!$factorId" />

                    @error('opciones')
                        <p class="text-xs font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                @endif


                {{-- Texto --}}
                <flux:textarea wire:model="texto" label="Texto de la pregunta" rows="3"
                    placeholder="Escriba la pregunta aquí..." :disabled="!$factorId" />

                @error('texto')
                    <p class="text-xs font-bold text-red-600">
                        {{ $message }}
                    </p>
                @enderror


                {{-- NPS --}}
                <flux:checkbox wire:model="es_nps" label="Calcular NPS"
                    description="Marcar si esta pregunta es de tipo Net Promoter Score." :disabled="!$factorId" />


                {{-- Botones --}}
                <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">

                    <flux:button type="button" variant="subtle" wire:click="cerrarModal">
                        Cancelar
                    </flux:button>


                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled" :disabled="!$factorId">

                        <span wire:loading.remove wire:target="guardar">
                            Guardar cambios
                        </span>

                        <span wire:loading wire:target="guardar">
                            Guardando...
                        </span>

                    </flux:button>

                </div>

            </form>

        </flux:modal>

    </div>
