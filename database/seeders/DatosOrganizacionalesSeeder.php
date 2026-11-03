<?php

namespace Database\Seeders;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatosOrganizacionalesSeeder extends Seeder
{
    /**
     * Carga puestos, usuarios, empleados y asignaciones de plantillas.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $puestos = $this->crearPuestos();
            $empleados = $this->crearEmpleados($puestos);
            $this->asignarPlantillas($empleados);
        });
    }

    /**
     * Define los puestos y las cuentas de prueba.
     */
    private function estructuraOrganizacional(): array
    {
        return [
            [
                'codigo' => 'GER-GEN',
                'nombre' => 'Gerente General',
                'email' => 'gerente.general@evaluaciones.test',
            ],

            // Gerencia de Operaciones
            [
                'codigo' => 'GER-OPE',
                'nombre' => 'Gerente de Operaciones',
                'email' => 'gerente.operaciones@evaluaciones.test',
            ],
            [
                'codigo' => 'MM-LOG',
                'nombre' => 'Jefe de Logística',
                'email' => 'jefe.logistica@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-FAC',
                'nombre' => 'Facturación y Cobros',
                'email' => 'facturacion.cobros@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-MEN-01',
                'nombre' => 'Mensajero',
                'email' => 'mensajero.facturacion@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-SCZ10',
                'nombre' => 'Servicio al cliente z.10',
                'email' => 'servicio.z10@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-SCL',
                'nombre' => 'Servicio al cliente y logística',
                'email' => 'servicio.logistica@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-MEN-02',
                'nombre' => 'Mensajero',
                'email' => 'mensajero.logistica@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-BOD',
                'nombre' => 'Encargado de bodega',
                'email' => 'encargado.bodega@evaluaciones.test',
            ],

            // Gerencia Regional de Ventas
            [
                'codigo' => 'GER-VEN',
                'nombre' => 'Gerente Regional de Ventas',
                'email' => 'gerente.ventas@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-ASV',
                'nombre' => 'Asistente de Ventas',
                'email' => 'asistente.ventas@evaluaciones.test',
            ],
            [
                'codigo' => 'MM-PRO',
                'nombre' => 'Product Manager',
                'email' => 'product.manager@evaluaciones.test',
            ],
            [
                'codigo' => 'MM-SUV',
                'nombre' => 'Supervisor de Ventas',
                'email' => 'supervisor.ventas@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-ATV',
                'nombre' => 'Asesores Técnicos de Ventas',
                'email' => 'asesores.ventas@evaluaciones.test',
            ],

            // Gerencia Centro de Soluciones al Cliente
            [
                'codigo' => 'GER-CSC',
                'nombre' => 'Gerente Centro de Soluciones al Cliente',
                'email' => 'gerente.soluciones@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-TPR',
                'nombre' => 'Técnicos de Proyectos',
                'email' => 'tecnicos.proyectos@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-ROB',
                'nombre' => 'Técnicos de Robótica & E-Drives',
                'email' => 'tecnicos.robotica@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-TSV',
                'nombre' => 'Técnicos de Servicios',
                'email' => 'tecnicos.servicios@evaluaciones.test',
            ],

            // Gerencia Administrativa
            [
                'codigo' => 'GER-ADM',
                'nombre' => 'Gerente Administrativa',
                'email' => 'gerente.administrativa@evaluaciones.test',
            ],
            [
                'codigo' => 'MM-SIS',
                'nombre' => 'Encargada de Sistemas',
                'email' => 'encargada.sistemas@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-SIS',
                'nombre' => 'Técnico de Sistemas',
                'email' => 'tecnico.sistemas@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-AAD',
                'nombre' => 'Asistente de Administración',
                'email' => 'asistente.administracion@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-MEN-03',
                'nombre' => 'Mensajero',
                'email' => 'mensajero.administracion@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-LIM',
                'nombre' => 'Encargada de Limpieza',
                'email' => 'encargada.limpieza@evaluaciones.test',
            ],

            // Contabilidad
            [
                'codigo' => 'GER-CON',
                'nombre' => 'Contador General',
                'email' => 'contador.general@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-CO1',
                'nombre' => 'Auxiliar de Contabilidad I',
                'email' => 'auxiliar.contabilidad1@evaluaciones.test',
            ],
            [
                'codigo' => 'OPE-CO2',
                'nombre' => 'Auxiliar de Contabilidad II',
                'email' => 'auxiliar.contabilidad2@evaluaciones.test',
            ],

            // Recursos Humanos
            [
                'codigo' => 'GER-RH',
                'nombre' => 'Encargada de Recursos Humanos',
                'email' => 'recursos.humanos@evaluaciones.test',
                'es_admin' => true,
            ],

            // Gerencia de Desarrollo Social admin
            [
                'codigo' => 'GER-ADMIN',
                'nombre' => 'Gerencia de Desarrollo Social',
                'email' => 'munigerenciasocial@gmail.com',
                'es_admin' => true,
            ],
        ];
    }

    /**
     * Crea los puestos y los devuelve agrupados por código.
     */
    private function crearPuestos(): array
    {
        $puestos = [];

        foreach ($this->estructuraOrganizacional() as $datos) {
            $puestos[$datos['codigo']] = Puesto::updateOrCreate(
                ['codigo' => $datos['codigo']],
                ['nombre' => $datos['nombre'], 'activo' => true]
            );
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

            $empleado = Empleado::updateOrCreate(
                [
                    'user_id' => $usuario->id,
                ],
                [
                    'puesto_id' => $puestos[$datos['codigo']]->id,
                    'activo' => true,
                ]
            );

            $empleados[$datos['codigo']] = $empleado;
        }

        return $empleados;
    }

    /**
     * Asigna las tres plantillas de prueba a empleados responsables.
     * Cada relación se crea una sola vez, incluso si el seeder se repite.
     */
    private function asignarPlantillas(array $empleados): void
    {
        $asignaciones = [
            'GER' => ['GER-GEN'],
            'MM'  => ['MM-LOG'],
            'OPE' => ['OPE-FAC'],
        ];

        foreach ($asignaciones as $codigoPlantilla => $codigosEmpleados) {
            $plantillaId = DB::table('plantillas')
                ->where('codigo', $codigoPlantilla)
                ->value('id');

            if ($plantillaId === null) {
                throw new \RuntimeException("No existe la plantilla {$codigoPlantilla}. Ejecute primero DatosInicialesSeeder.");
            }

            foreach ($codigosEmpleados as $codigoEmpleado) {
                if (!isset($empleados[$codigoEmpleado])) {
                    throw new \RuntimeException("No existe el empleado de prueba {$codigoEmpleado}.");
                }

                DB::table('plantilla_empleado')->updateOrInsert(
                    [
                        'plantilla_id' => $plantillaId,
                        'empleado_id' => $empleados[$codigoEmpleado]->id,
                    ],
                    fn (bool $exists) => ['updated_at' => now()]
                        + ($exists ? [] : ['created_at' => now()])
                );
            }
        }
    }
}
