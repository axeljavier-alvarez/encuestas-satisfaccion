
@props([
    'name',
    'type' => 'text',
    'placeholder' => '',
    'icon' => 'user',
    'value' => '',
    'autocomplete' => null,
    'required' => false,
])


<style>
    .auth-icon-container {
        position: relative;
        width: 100%;
    }

    .auth-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #273385;
        pointer-events: none;
        z-index: 1;
    }

    .auth-icon-container input {
        padding-left: 44px !important;
        height: 48px;
        border: 1px solid #273385;
        border-radius: 0;
        box-sizing: border-box;
    }
</style>


<div class="w-full">

    <div class="auth-icon-container">

        <!-- Icono -->
        <div class="auth-icon">

            @if ($icon === 'user')
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="17" height="17"
                     viewBox="0 0 24 24"
                     fill="currentColor">
                    <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.42 0-8 2.24-8 5v3h16v-3c0-2.76-3.58-5-8-5Z"/>
                </svg>
            @elseif ($icon === 'lock')
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="17" height="17"
                     viewBox="0 0 24 24"
                     fill="currentColor">
                    <path d="M18 8h-1V6a5 5 0 0 0-10 0v2H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2ZM9 6a3 3 0 0 1 6 0v2H9Z"/>
                </svg>
            @elseif ($icon === 'mail')
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="17" height="17"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="m2 6 10 7 10-7"/>
                </svg>
            @endif

        </div>

        <!-- Campo -->
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $type === 'password' ? '' : old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($required) required @endif
            {{ $attributes->class([
                'w-full h-12 border border-[#273385] rounded-none',
                'bg-transparent pl-11 pr-4 text-sm text-[#171f61]',
                'placeholder:text-[#8188b5]',
                'focus:outline-none focus:ring-1 focus:ring-[#273385]',
            ]) }}
        />

    </div>

    <!-- Error de validación -->
    @error($name)
        <p class="mt-1 text-xs text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>
