<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">
        Configuración del perfil
    </flux:heading>

    <x-settings.layout
        heading="Perfil"
        subheading="Actualice su nombre y correo electrónico"
    >
        <form
            wire:submit="updateProfileInformation"
            class="my-6 w-full space-y-6"
        >
            <flux:input
                wire:model="name"
                label="Nombre"
                type="text"
                required
                autofocus
                autocomplete="name"
            />

            <div>
                <flux:input
                    wire:model="email"
                    label="Correo electrónico"
                    type="email"
                    required
                    autocomplete="email"
                />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            Su correo electrónico todavía no ha sido verificado.

                            <flux:link
                                class="cursor-pointer text-sm"
                                wire:click.prevent="resendVerificationNotification"
                            >
                                Presione aquí para reenviar el correo de verificación.
                            </flux:link>
                        </flux:text>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <flux:button
                    variant="primary"
                    type="submit"
                >
                    Guardar cambios
                </flux:button>
            </div>
        </form>
    </x-settings.layout>
</section>
