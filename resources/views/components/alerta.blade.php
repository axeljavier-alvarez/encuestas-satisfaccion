@props([
    'duracion' => 5000,
])

<div
    x-data="{
        mostrar: false,
        mensaje: '',
        tipo: 'success',
        temporizador: null,

        cerrar() {
            this.mostrar = false;
            clearTimeout(this.temporizador);
        }
    }"
    x-on:mostrar-mensaje.window="
        mensaje = $event.detail.mensaje;
        tipo = $event.detail.tipo || 'success';
        mostrar = true;

        clearTimeout(temporizador);

        temporizador = setTimeout(() => {
            mostrar = false;
        }, {{ (int) $duracion }});
    "
    x-show="mostrar"
    x-cloak
    x-transition.opacity.duration.300ms
    :class="{
        'alerta-success': tipo === 'success',
        'alerta-error': tipo === 'error',
        'alerta-warning': tipo === 'warning',
        'alerta-info': tipo === 'info'
    }"
    {{ $attributes->class([
        'alerta flex items-center justify-between gap-3'
    ]) }}
    role="alert"
>
    <div class="flex items-center gap-3">

        <span x-show="tipo === 'success'">
            <flux:icon.check-circle class="size-5" />
        </span>

        <span x-show="tipo === 'error'" x-cloak>
            <flux:icon.x-circle class="size-5" />
        </span>

        <span x-show="tipo === 'warning'" x-cloak>
            <flux:icon.exclamation-triangle class="size-5" />
        </span>

        <span x-show="tipo === 'info'" x-cloak>
            <flux:icon.information-circle class="size-5" />
        </span>

        <span x-text="mensaje"></span>
    </div>

    <button
        type="button"
        x-on:click="cerrar()"
        class="alerta-cerrar ml-auto flex shrink-0 items-center justify-center"
        aria-label="Cerrar mensaje"
    >
        <flux:icon.x-mark class="size-5" />
    </button>
</div>


<style>
    /* =========================================
   ALERTAS DEL SISTEMA
========================================= */

.alerta {
    border: 1px solid;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

/* ÉXITO - VERDE */
.alerta-success {
    background-color: #ecfdf5;
    border-color: #a7f3d0;
    color: #065f46;
}

/* ERROR - ROJO */
.alerta-error {
    background-color: #fff1f2;
    border-color: #fecdd3;
    color: #9f1239;
}

/* ADVERTENCIA - AMARILLO */
.alerta-warning {
    background-color: #fffbeb;
    border-color: #fde68a;
    color: #92400e;
}

/* INFORMACIÓN - AZUL */
.alerta-info {
    background-color: #eff6ff;
    border-color: #bfdbfe;
    color: #1e40af;
}

/* BOTÓN CERRAR */
.alerta-cerrar {
    border: none;
    background: transparent;
    color: inherit;
    cursor: pointer;
    padding: 4px;
    border-radius: 6px;
    transition: background-color 0.2s;
}

.alerta-cerrar:hover {
    background-color: rgba(0, 0, 0, 0.08);
}

/* OCULTAR ELEMENTOS DE ALPINE */
[x-cloak] {
    display: none !important;
}
</style>