<?php

namespace App\Livewire\Settings;

use App\Concerns\PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Configuración de seguridad')]
class Security extends Component
{
    use PasswordValidationRules;

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Actualiza la contraseña del usuario autenticado.
     */
    public function updatePassword()
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset(
                'current_password',
                'password',
                'password_confirmation'
            );

            throw $e;
        }

        /*
         * El modelo User ya tiene configurado el cast "hashed",
         * por lo que Laravel protegerá automáticamente la contraseña.
         */
        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        /*
         * Cierra la sesión después del cambio de contraseña.
         */
        Auth::logout();

        /*
         * Invalida la sesión anterior y genera un token nuevo.
         */
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        /*
         * Regresa al login mostrando un mensaje de confirmación.
         */
        return redirect()
            ->route('login')
            ->with(
                'status',
                'Contraseña actualizada correctamente. Inicie sesión nuevamente.'
            );
    }

    /**
     * Muestra la vista de seguridad.
     */
    public function render()
    {
        return view('livewire.settings.security');
    }
}