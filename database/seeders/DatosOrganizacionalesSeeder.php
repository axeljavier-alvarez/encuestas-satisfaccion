<?php

namespace Database\Seeders;

use App\Models\Empleado;
use App\Models\Plantilla;
use App\Models\Puesto;
use App\Models\RelacionPuesto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatosOrganizacionalesSeeder extends Seeder
{
    /**
     * Carga los puestos, usuarios, empleados y reglas
     * de evaluación según el organigrama.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $puestos = $this->crearPuestos();
            $empleados = $this->crearEmpleados($puestos);
            $this->crearRelacionesPuestos($puestos);
        });
    }

    /**
     * Crea los puestos del organigrama.
     *
     * jefe_codigo identifica el puesto superior inmediato.
     * El Gerente General no tiene jefe.
     */
    private function estructuraOrganizacional(): array
    {
        return [
            [
                'codigo' => 'GER-GEN',
                'nombre' => 'Gerente General',
                'plantilla' => 'GER',
                'jefe_codigo' => null,
                'email' => 'gerente.general@evaluaciones.test',
            ],

            // Gerencia de Operaciones
            [
                'codigo' => 'GER-OPE',
                'nombre' => 'Gerente de Operaciones',
                'plantilla' => 'GER',
                'jefe_codigo' => 'GER-GEN',
                'email' => 'gerente.operaciones@evaluaciones.test',
            ],
            [
                'codigo' => 'MM-LOG',
                'nombre' => 'Jefe de Logística',
                'plantilla' => 'MM',
                'jefe_codigo' => 'GER-OPE',
                'email' => 'jefe.logistica@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-FAC',
                'nombre' => 'Facturación y Cobros',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'MM-LOG',
                'email' => 'facturacion.cobros@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-MEN-01',
                'nombre' => 'Mensajero',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'OPE-FAC',
                'email' => 'mensajero.facturacion@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-SCZ10',
                'nombre' => 'Servicio al cliente z.10',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'MM-LOG',
                'email' => 'servicio.z10@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-SCL',
                'nombre' => 'Servicio al cliente y logística',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'MM-LOG',
                'email' => 'servicio.logistica@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-MEN-02',
                'nombre' => 'Mensajero',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'OPE-SCL',
                'email' => 'mensajero.logistica@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-BOD',
                'nombre' => 'Encargado de bodega',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'MM-LOG',
                'email' => 'encargado.bodega@evaluaciones.test',
            ],

            // Gerencia Regional de Ventas
            [
                'codigo' => 'GER-VEN',
                'nombre' => 'Gerente Regional de Ventas',
                'plantilla' => 'GER',
                'jefe_codigo' => 'GER-GEN',
                'email' => 'gerente.ventas@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-ASV',
                'nombre' => 'Asistente de Ventas',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-VEN',
                'email' => 'asistente.ventas@evaluaciones.test',
            ],
            [
                'codigo' => 'MM-PRO',
                'nombre' => 'Product Manager',
                'plantilla' => 'MM',
                'jefe_codigo' => 'GER-VEN',
                'email' => 'product.manager@evaluaciones.test',
            ],
            [
                'codigo' => 'MM-SUV',
                'nombre' => 'Supervisor de Ventas',
                'plantilla' => 'MM',
                'jefe_codigo' => 'GER-VEN',
                'email' => 'supervisor.ventas@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-ATV',
                'nombre' => 'Asesores Técnicos de Ventas',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'MM-SUV',
                'email' => 'asesores.ventas@evaluaciones.test',
            ],

            // Gerencia Centro de Soluciones al Cliente
            [
                'codigo' => 'GER-CSC',
                'nombre' => 'Gerente Centro de Soluciones al Cliente',
                'plantilla' => 'GER',
                'jefe_codigo' => 'GER-GEN',
                'email' => 'gerente.soluciones@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-TPR',
                'nombre' => 'Técnicos de Proyectos',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-CSC',
                'email' => 'tecnicos.proyectos@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-ROB',
                'nombre' => 'Técnicos de Robótica & E-Drives',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-CSC',
                'email' => 'tecnicos.robotica@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-TSV',
                'nombre' => 'Técnicos de Servicios',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-CSC',
                'email' => 'tecnicos.servicios@evaluaciones.test',
            ],

            // Gerencia Administrativa
            [
                'codigo' => 'GER-ADM',
                'nombre' => 'Gerente Administrativa',
                'plantilla' => 'GER',
                'jefe_codigo' => 'GER-GEN',
                'email' => 'gerente.administrativa@evaluaciones.test',
            ],
            [
                'codigo' => 'MM-SIS',
                'nombre' => 'Encargada de Sistemas',
                'plantilla' => 'MM',
                'jefe_codigo' => 'GER-ADM',
                'email' => 'encargada.sistemas@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-SIS',
                'nombre' => 'Técnico de Sistemas',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'MM-SIS',
                'email' => 'tecnico.sistemas@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-AAD',
                'nombre' => 'Asistente de Administración',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-ADM',
                'email' => 'asistente.administracion@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-MEN-03',
                'nombre' => 'Mensajero',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-ADM',
                'email' => 'mensajero.administracion@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-LIM',
                'nombre' => 'Encargada de Limpieza',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-ADM',
                'email' => 'encargada.limpieza@evaluaciones.test',
            ],

            // Contabilidad
            [
                'codigo' => 'GER-CON',
                'nombre' => 'Contador General',
                'plantilla' => 'GER',
                'jefe_codigo' => 'GER-GEN',
                'email' => 'contador.general@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-CO1',
                'nombre' => 'Auxiliar de Contabilidad I',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-CON',
                'email' => 'auxiliar.contabilidad1@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-CO2',
                'nombre' => 'Auxiliar de Contabilidad II',
                'plantilla' => 'OPE',
                'jefe_codigo' => 'GER-CON',
                'email' => 'auxiliar.contabilidad2@evaluaciones.test',
            ],

            // Recursos Humanos
            [
                'codigo' => 'GER-RH',
                'nombre' => 'Encargada de Recursos Humanos',
                'plantilla' => 'GER',
                'jefe_codigo' => 'GER-GEN',
                'email' => 'recursos.humanos@evaluaciones.test',
                'es_admin' => true,
            ],
        ];
    }

    /**
     * Crea los puestos y los devuelve agrupados por código.
     */
    private function crearPuestos(): array
    {
        $plantillas = Plantilla::query()
            ->whereIn('codigo', ['GER', 'MM', 'OPE'])
            ->get()
            ->keyBy('codigo');

        $puestos = [];

        foreach ($this->estructuraOrganizacional() as $datos) {
            $plantilla = $plantillas->get($datos['plantilla']);

            $puesto = Puesto::updateOrCreate(
                [
                    'codigo' => $datos['codigo'],
                ],
                [
                    'nombre' => $datos['nombre'],
                    'plantilla_id' => $plantilla->id,
                    'activo' => true,
                ]
            );

            $puestos[$datos['codigo']] = $puesto;
        }

        return $puestos;
    }

    /**
     * Crea un usuario y un empleado para cada puesto.
     *
     * La contraseña se utilizará solamente en el entorno local
     * de demostración.
     */
    private function crearEmpleados(array $puestos): array
    {
        $empleados = [];

        foreach ($this->estructuraOrganizacional() as $datos) {
            $usuario = User::updateOrCreate(
                [
                    'email' => $datos['email'],
                ],
                [
                    'name' => $datos['nombre'],
                    'password' => Hash::make('ClaveDemo2026*'),
                    //  es admin si se especifica explicitamente
                    'es_admin' => $datos['es_admin'] ?? false,
                ]
            );

            $jefe = $datos['jefe_codigo']
                ? $empleados[$datos['jefe_codigo']]
                : null;

            $empleado = Empleado::updateOrCreate(
                [
                    'user_id' => $usuario->id,
                ],
                [
                    'puesto_id' => $puestos[$datos['codigo']]->id,
                    'jefe_id' => $jefe?->id,
                    'activo' => true,
                ]
            );

            $empleados[$datos['codigo']] = $empleado;
        }

        return $empleados;
    }

    /**
     * Crea reglas de evaluación en ambos sentidos:
     *
     * superior evalúa a subordinado
     * subordinado evalúa a superior inmediato
     */
    private function crearRelacionesPuestos(array $puestos): void
    {
        foreach ($this->estructuraOrganizacional() as $datos) {
            if ($datos['jefe_codigo'] === null) {
                continue;
            }

            $puestoSuperior = $puestos[$datos['jefe_codigo']];
            $puestoSubordinado = $puestos[$datos['codigo']];

            RelacionPuesto::updateOrCreate(
                [
                    'puesto_evaluador_id' => $puestoSuperior->id,
                    'puesto_evaluado_id' => $puestoSubordinado->id,
                ],
                [
                    'activo' => true,
                ]
            );

            RelacionPuesto::updateOrCreate(
                [
                    'puesto_evaluador_id' => $puestoSubordinado->id,
                    'puesto_evaluado_id' => $puestoSuperior->id,
                ],
                [
                    'activo' => true,
                ]
            );
        }
    }
}