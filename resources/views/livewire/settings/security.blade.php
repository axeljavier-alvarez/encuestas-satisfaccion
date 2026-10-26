<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">
        Configuración de seguridad
    </flux:heading>

    <x-settings.layout
        heading="Cambiar contraseña"
        subheading="Utilice una contraseña segura para proteger su cuenta"
    >
        <form
            method="POST"
            wire:submit="updatePassword"
            class="mt-6 space-y-6"
        >
            <flux:input
                wire:model="current_password"
                label="Contraseña actual"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Ingrese su contraseña actual"
                viewable
            />

            <flux:input
                wire:model="password"
                label="Nueva contraseña"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Ingrese la nueva contraseña"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <flux:input
                wire:model="password_confirmation"
                label="Confirmar nueva contraseña"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Repita la nueva contraseña"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <div class="flex items-center gap-4">
                <flux:button
                    variant="primary"
                    type="submit"
                    data-test="update-password-button"
                >
                    Guardar cambios
                </flux:button>
            </div>
        </form>
    </x-settings.layout>
</section>