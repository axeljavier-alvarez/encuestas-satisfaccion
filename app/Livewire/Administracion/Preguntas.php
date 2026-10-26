<?php

namespace App\Livewire\Administracion;

use App\Models\{Escala, Factor, Pregunta, Tema, TipoRespuesta};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Preguntas extends Component
{
    use WithPagination;

    #[Url]
    public string $buscar = '';
    public string $filtroNps = 'todos';
    public bool $mostrarModal = false;
    public ?int $preguntaId = null;
    public ?int $factorId = null;
    public ?int $temaId = null;
    public bool $es_nps = false;
    public bool $activo = false;
    public string $texto = '';
    public string $codigo = '';
    public bool $obligatoria = false;
    public bool $es_predeterminada = false;
    public bool $predeterminadaOriginal = false;
    public string $filtroFactor = '';
    public string $filtroTema = '';
    public string $filtroTipo = '';

    public string $filtroPredeterminada = 'todos';

    /** Cada configuración tiene su propio tipo, escala y opciones. */
    public array $configuraciones = [];
    public bool $variosTipos = false;
    public int $siguienteClave = 0;

    private function nuevaOpcion(): array
    {
        return [
            'id' => null,
            'valor' => '',
            'etiqueta' => '',
            'es_excluyente' => false,
            'habilita_texto' => false,
            'etiqueta_texto_adicional' => '',
        ];
    }

    public function crear(): void
    {
        $this->limpiarFormulario();
        $this->agregarTipo();
        $this->mostrarModal = true;
    }

    public function agregarTipo(): void
    {
        if (!$this->variosTipos && count($this->configuraciones) >= 1) {
            return;
        }
        $clave = $this->siguienteClave++;
        $this->configuraciones[$clave] = [
            'id' => null,
            'tipo_respuesta_id' => '',
            'escala_id' => '',
            'opciones' => [],
        ];
    }

    public function eliminarTipo(int $clave): void
    {
        if (!isset($this->configuraciones[$clave]) || count($this->configuraciones) <= 1) {
            return;
        }
        unset($this->configuraciones[$clave]);
        $this->resetValidation();
    }

    public function updatedVariosTipos(bool $valor): void
    {
        if (!$valor && count($this->configuraciones) > 1) {
            $primeraClave = array_key_first($this->configuraciones);
            $this->configuraciones = [$primeraClave => $this->configuraciones[$primeraClave]];
        }
    }

    public function updatedConfiguraciones($valor, string $ruta): void
    {
        $partes = explode('.', $ruta);
        if (count($partes) === 2 && $partes[1] === 'tipo_respuesta_id') {
            $clave = (int) $partes[0];
            if (!isset($this->configuraciones[$clave])) {
                return;
            }
            $this->configuraciones[$clave]['escala_id'] = '';
            $this->configuraciones[$clave]['opciones'] = [];
            if ($this->esSeleccion($clave)) {
                $this->agregarOpcion($clave);
                $this->agregarOpcion($clave);
            }
            $this->resetValidation();
        }
    }

    public function nombreTipo(int $clave): ?string
    {
        $id = $this->configuraciones[$clave]['tipo_respuesta_id'] ?? null;
        return $id ? TipoRespuesta::whereKey($id)->value('nombre') : null;
    }

    public function esEscala(int $clave): bool
    {
        return $this->nombreTipo($clave) === 'Escala de 0 a 10';
    }

    public function esSeleccion(int $clave): bool
    {
        return in_array($this->nombreTipo($clave), ['Selección única', 'Selección múltiple'], true);
    }

    public function agregarOpcion(int $clave): void
    {
        if (isset($this->configuraciones[$clave])) {
            $this->configuraciones[$clave]['opciones'][] = $this->nuevaOpcion();
        }
    }

    public function eliminarOpcion(int $clave, int $indice): void
    {
        if (!isset($this->configuraciones[$clave]['opciones'][$indice])) {
            return;
        }
        array_splice($this->configuraciones[$clave]['opciones'], $indice, 1);
        $this->resetValidation();
    }

    private function opcionTieneRespuestas(int $opcionId): bool
    {
        return Schema::hasTable('respuestas')
            && Schema::hasColumn('respuestas', 'opcion_respuesta_id')
            && DB::table('respuestas')->where('opcion_respuesta_id', $opcionId)->exists();
    }

    private function validarDependenciasConfiguracion($configuracion): void
    {
        foreach ($configuracion->opcionesRespuesta as $opcion) {
            if ($this->opcionTieneRespuestas($opcion->id)) {
                throw ValidationException::withMessages([
                    'configuraciones' => 'No se puede eliminar un tipo u opción que ya tiene respuestas registradas.',
                ]);
            }
        }
        // Evita perder referencias si las plantillas seleccionan una configuración específica.
        if (
            Schema::hasTable('plantilla_pregunta')
            && Schema::hasColumn('plantilla_pregunta', 'pregunta_tipo_respuesta_id')
            && DB::table('plantilla_pregunta')->where('pregunta_tipo_respuesta_id', $configuracion->id)->exists()
        ) {
            throw ValidationException::withMessages([
                'configuraciones' => 'No puede eliminar un tipo utilizado en una plantilla.',
            ]);
        }
    }

    public function guardar(): void
    {
        $reglas = [
            'factorId' => ['required', 'exists:factores,id'],
            'temaId' => ['required', 'exists:temas,id'],
            'codigo' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9_-]+$/', Rule::unique('preguntas', 'codigo')->ignore($this->preguntaId)],
            'obligatoria' => ['required', 'boolean'],
            'es_predeterminada' => ['required', 'boolean'],
            'texto' => ['required', 'string', 'max:65535'],
            'es_nps' => ['boolean'],
            'configuraciones' => ['required', 'array', 'min:1'],
        ];

        $tipos = TipoRespuesta::pluck('nombre', 'id');
        $tiposUsados = [];
        $tieneEscalaNps = false;

        foreach ($this->configuraciones as $clave => $config) {
            $prefijo = "configuraciones.$clave";
            $reglas["$prefijo.tipo_respuesta_id"] = ['required', 'integer', 'exists:tipos_respuesta,id'];
            $tipoId = (int) ($config['tipo_respuesta_id'] ?? 0);
            $nombre = $tipos[$tipoId] ?? null;
            $esEscala = $nombre === 'Escala de 0 a 10';
            $esSeleccion = in_array($nombre, ['Selección única', 'Selección múltiple'], true);
            $reglas["$prefijo.escala_id"] = [$esEscala ? 'required' : 'nullable', 'exists:escalas,id'];
            $reglas["$prefijo.opciones"] = $esSeleccion ? ['required', 'array', 'min:2'] : ['array'];
            if ($esSeleccion) {
                $reglas["$prefijo.opciones.*.valor"] = ['required', 'string', 'max:50'];
                $reglas["$prefijo.opciones.*.etiqueta"] = ['required', 'string', 'max:100'];
                $reglas["$prefijo.opciones.*.es_excluyente"] = ['boolean'];
                $reglas["$prefijo.opciones.*.habilita_texto"] = ['boolean'];
                $reglas["$prefijo.opciones.*.etiqueta_texto_adicional"] = ['nullable', 'string', 'max:150'];
            }
            if ($tipoId && in_array($tipoId, $tiposUsados, true)) {
                throw ValidationException::withMessages([$prefijo . '.tipo_respuesta_id' => 'No puede repetir el mismo tipo de respuesta.']);
            }
            $tiposUsados[] = $tipoId;
            if ($esSeleccion) {
                $valores = array_map(fn($op) => mb_strtolower(trim((string) ($op['valor'] ?? ''))), $config['opciones'] ?? []);
                if (count($valores) !== count(array_unique($valores))) {
                    throw ValidationException::withMessages([$prefijo . '.opciones' => 'Los valores de las opciones no pueden repetirse dentro de este tipo.']);
                }
                foreach ($config['opciones'] ?? [] as $indice => $op) {
                    if (!empty($op['habilita_texto']) && trim((string) ($op['etiqueta_texto_adicional'] ?? '')) === '') {
                        throw ValidationException::withMessages(["$prefijo.opciones.$indice.etiqueta_texto_adicional" => 'Escriba la etiqueta del campo adicional.']);
                    }
                }
            }
            if ($esEscala && !empty($config['escala_id'])) {
                $escalaNps = Escala::whereKey($config['escala_id'])->where('minimo', 0)->where('maximo', 10)
                    ->where('permite_no_sabe', false)->where('permite_no_aplica', false)->exists();
                $tieneEscalaNps = $tieneEscalaNps || $escalaNps;
            }
        }

        $this->validate($reglas);
        if (!$this->variosTipos && count($this->configuraciones) > 1) {
            throw ValidationException::withMessages(['configuraciones' => 'Active la opción de varios tipos para agregar más de uno.']);
        }
        if ($this->es_nps && !$tieneEscalaNps) {
            throw ValidationException::withMessages(['es_nps' => 'NPS requiere una escala de 0 a 10 sin No sabe ni No aplica.']);
        }

        $esEdicion = $this->preguntaId !== null;
        DB::transaction(function () use ($esEdicion, $tipos) {
            // Usar el mismo bloqueo que cambiarEstado() para serializar cambios.
            $preguntasBloqueadas = Pregunta::query()->orderBy('id')->lockForUpdate()->get();
            $pregunta = $esEdicion
                ? $preguntasBloqueadas->firstWhere('id', $this->preguntaId)
                : new Pregunta();

            if ($esEdicion && !$pregunta) {
                abort(404);
            }

            if ($this->es_predeterminada) {
                if (!$esEdicion || !$pregunta->activo) {
                    throw ValidationException::withMessages([
                        'es_predeterminada' => 'Solo una pregunta activa y existente puede ser predeterminada.',
                    ]);
                }

                $totalOtras = $preguntasBloqueadas->filter(
                    fn($item) => $item->activo && $item->es_predeterminada && $item->id !== $pregunta->id
                )->count();

                if ($totalOtras >= 2) {
                    throw ValidationException::withMessages([
                        'es_predeterminada' => 'Ya existen 2 preguntas predeterminadas activas. Desmarque una antes de seleccionar otra.',
                    ]);
                }
            }

            $pregunta->fill([
                'codigo' => trim($this->codigo),
                'factor_id' => $this->factorId,
                'tema_id' => $this->temaId,
                'texto' => trim($this->texto),
                'es_nps' => $this->es_nps,
                'obligatoria' => $this->es_predeterminada ? true : $this->obligatoria,
                'es_predeterminada' => $this->es_predeterminada,
            ]);
            if (!$esEdicion) {
                $pregunta->activo = false;
            }
            $pregunta->save();

            $idsConservar = [];
            foreach ($this->configuraciones as $config) {
                $tipoId = (int) $config['tipo_respuesta_id'];
                $nombre = $tipos[$tipoId] ?? '';
                $esSeleccion = in_array($nombre, ['Selección única', 'Selección múltiple'], true);
                $configuracion = $pregunta->configuracionesRespuesta()->firstOrNew(['tipo_respuesta_id' => $tipoId]);
                $configuracion->escala_id = $nombre === 'Escala de 0 a 10' ? (int) $config['escala_id'] : null;
                $configuracion->save();
                $idsConservar[] = $configuracion->id;

                if ($esSeleccion) {
                    $opcionesConservar = [];
                    foreach ($config['opciones'] as $op) {
                        // Conservar el ID original al editar una opción; no romper respuestas históricas.
                        $id = $op['id'] ?? null;
                        $registro = $id ? $configuracion->opcionesRespuesta()->findOrFail($id)
                            : $configuracion->opcionesRespuesta()->firstOrNew(['valor' => trim($op['valor'])]);
                        $registro->valor = trim($op['valor']);
                        $registro->etiqueta = trim($op['etiqueta']);
                        $registro->es_excluyente = (bool) ($op['es_excluyente'] ?? false);
                        $registro->habilita_texto = (bool) ($op['habilita_texto'] ?? false);
                        $registro->etiqueta_texto_adicional = $registro->habilita_texto ? trim($op['etiqueta_texto_adicional']) : null;
                        $registro->save();
                        $opcionesConservar[] = $registro->id;
                    }
                    $sobrantes = $configuracion->opcionesRespuesta()->whereNotIn('id', $opcionesConservar)->get();
                    foreach ($sobrantes as $sobrante) {
                        if ($this->opcionTieneRespuestas($sobrante->id)) {
                            throw ValidationException::withMessages(['configuraciones' => 'No puede quitar opciones que ya tienen respuestas.']);
                        }
                        $sobrante->delete();
                    }
                } else {
                    foreach ($configuracion->opcionesRespuesta as $opcion) {
                        if ($this->opcionTieneRespuestas($opcion->id)) {
                            throw ValidationException::withMessages(['configuraciones' => 'No puede quitar opciones con respuestas registradas.']);
                        }
                        $opcion->delete();
                    }
                }
            }
            foreach ($pregunta->configuracionesRespuesta()->with('opcionesRespuesta')->whereNotIn('id', $idsConservar)->get() as $sobrante) {
                $this->validarDependenciasConfiguracion($sobrante);
                $sobrante->delete();
            }
        });

        $this->cerrarModal();
        session()->flash('mensaje', $esEdicion ? 'La pregunta fue actualizada correctamente' : 'La pregunta fue creada correctamente');
    }

    public function editar(int $preguntaId): void
    {
        $pregunta = Pregunta::with('configuracionesRespuesta.tipoRespuesta', 'configuracionesRespuesta.opcionesRespuesta')->findOrFail($preguntaId);
        $this->limpiarFormulario();
        $this->preguntaId = $pregunta->id;
        $this->factorId = $pregunta->factor_id;
        $this->temaId = $pregunta->tema_id;
        $this->es_nps = (bool) $pregunta->es_nps;
        $this->activo = (bool) $pregunta->activo;
        $this->texto = $pregunta->texto;
        $this->codigo = (string) $pregunta->codigo;
        $this->obligatoria = (bool) $pregunta->obligatoria;
        $this->es_predeterminada = (bool) $pregunta->es_predeterminada;
        $this->predeterminadaOriginal = (bool) $pregunta->es_predeterminada;
        $this->variosTipos = $pregunta->configuracionesRespuesta->count() > 1;

        foreach ($pregunta->configuracionesRespuesta as $config) {
            $clave = $this->siguienteClave++;
            $this->configuraciones[$clave] = [
                'id' => $config->id,
                'tipo_respuesta_id' => (string) $config->tipo_respuesta_id,
                'escala_id' => $config->escala_id ? (string) $config->escala_id : '',
                'opciones' => $config->opcionesRespuesta->map(fn($op) => [
                    'id' => $op->id,
                    'valor' => $op->valor,
                    'etiqueta' => $op->etiqueta,
                    'es_excluyente' => (bool) $op->es_excluyente,
                    'habilita_texto' => (bool) $op->habilita_texto,
                    'etiqueta_texto_adicional' => (string) ($op->etiqueta_texto_adicional ?? ''),
                ])->values()->all(),
            ];
            if ($this->esSeleccion($clave) && count($this->configuraciones[$clave]['opciones']) === 0) {
                $this->agregarOpcion($clave);
                $this->agregarOpcion($clave);
            }
        }
        if (!$this->configuraciones) {
            $this->agregarTipo();
        }
        $this->mostrarModal = true;
    }

    public function cambiarEstado(int $preguntaId): void
    {
        DB::transaction(function () use ($preguntaId) {
            // Mismo orden de bloqueo que guardar().
            $preguntasBloqueadas = Pregunta::query()->orderBy('id')->lockForUpdate()->get();
            $pregunta = $preguntasBloqueadas->firstWhere('id', $preguntaId);

            if (!$pregunta) {
                abort(404);
            }

            if ($pregunta->activo && $pregunta->es_predeterminada) {
                throw ValidationException::withMessages([
                    'es_predeterminada' => 'Primero edite la pregunta y desmarque Predeterminada antes de desactivarla.',
                ]);
            }

            $pregunta->activo = !$pregunta->activo;
            $pregunta->save();
        });

        session()->flash('mensaje', 'Estado de la pregunta actualizado correctamente.');
    }

    public function updatedFactorId(): void
    {
        $this->temaId = null;
    }

    public function cerrarModal(): void
    {
        $this->mostrarModal = false;
        $this->limpiarFormulario();
    }

    public function limpiarFormulario(): void
    {
        $this->reset(['preguntaId', 'factorId', 'temaId', 'texto', 'codigo', 'obligatoria', 'es_predeterminada', 'predeterminadaOriginal', 'es_nps', 'configuraciones', 'variosTipos', 'siguienteClave']);
        $this->activo = false;
        $this->resetValidation();
    }

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }
    public function updatedFiltroNps(): void
    {
        $this->resetPage();
    }
    public function updatedFiltroFactor(): void
    {
        $this->filtroTema = '';
        $this->resetPage();
    }
    public function updatedFiltroTema(): void
    {
        $this->resetPage();
    }
    public function updatedFiltroTipo(): void
    {
        $this->resetPage();
    }
    public function updatedFiltroPredeterminada(): void
    {
        $this->resetPage();
    }
    public function limpiarFiltros(): void
    {
        $this->buscar = '';
        $this->filtroNps = 'todos';
        $this->filtroPredeterminada = 'todos';
        $this->filtroFactor = '';
        $this->filtroTema = '';
        $this->filtroTipo = '';
        $this->resetPage();
    }

    public function render()
    {
        $consulta = Pregunta::with(['factor', 'tema', 'tiposRespuesta']);
        if (trim($this->buscar) !== '') {
            $buscar = trim($this->buscar);
            $consulta->where(fn($q) => $q->where('texto', 'like', "%{$buscar}%")->orWhere('codigo', 'like', "%{$buscar}%"));
        }
        if ($this->filtroNps === 'nps') {
            $consulta->where('es_nps', true);
        } elseif ($this->filtroNps === 'no-nps') {
            $consulta->where('es_nps', false);
        }
        // Filtrar preguntas predeterminadas
        if ($this->filtroPredeterminada === 'predeterminadas') {
            $consulta->where('es_predeterminada', true);
        } elseif ($this->filtroPredeterminada === 'no-predeterminadas') {
            $consulta->where('es_predeterminada', false);
        }

        if ($this->filtroFactor !== '') {
            $consulta->where('factor_id', (int) $this->filtroFactor);
        }
        if ($this->filtroTema !== '') {
            $consulta->where('tema_id', (int) $this->filtroTema);
        }
        if ($this->filtroTipo !== '') {
            $consulta->whereHas('tiposRespuesta', fn($q) => $q->where('tipos_respuesta.id', (int) $this->filtroTipo));
        }
        return view('livewire.administracion.preguntas', [
            'preguntas' => $consulta->orderByDesc('id')->paginate(10),
            'factores' => Factor::where('activo', true)->orderBy('nombre')->get(),
            'temas' => Tema::where('activo', true)->orderBy('nombre')->get(),
            'tiposRespuesta' => TipoRespuesta::orderBy('nombre')->get(),
            'escalas' => Escala::orderBy('nombre')->get(),
            'totalPredeterminadas' => Pregunta::where('activo', true)->where('es_predeterminada', true)->count(),
            'totalActivas' => Pregunta::where('activo', true)->count(),
            'totalInactivas' => Pregunta::where('activo', false)->count(),
        ]);
    }
}
