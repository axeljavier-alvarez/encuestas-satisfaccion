<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatosOrganizacionalesSeeder extends Seeder
{
    /**
     * Crea únicamente los usuarios del sistema.
     *
     * Roles:
     * - admin: administrador
     * - asignador: responsable de asignar encuestas
     */
    public function run(): void
    {
        DB::transaction(function () {

            $usuarios = [
                [
                    'name' => 'Encargada de Recursos Humanos',
                    'email' => 'recursos.humanos@evaluaciones.test',
                    'rol' => 'admin',
                ],
                [
                    'name' => 'Gerencia de Desarrollo Social',
                    'email' => 'munigerenciasocial@gmail.com',
                    'rol' => 'admin',
                ],
                [
                    'name' => 'Asignador de Encuestas',
                    'email' => 'asistente.administracion@evaluaciones.test',
                    'rol' => 'asignador',
                ],
            ];

            foreach ($usuarios as $datos) {

                User::updateOrCreate(
                    [
                        'email' => $datos['email'],
                    ],
                    [
                        'name' => $datos['name'],
                        'password' => Hash::make('ClaveDemo2026*'),
                        'rol' => $datos['rol'],
                    ]
                );

            }

        });
    }
}
