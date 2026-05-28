<div x-data="{ showPassword: false }" class="mt-2">
    <x-form.label :required="true" name="{{ $name }}">
        {{ $label }}
    </x-form.label>

    <div class="relative">
        <input
            :type="showPassword ? 'text' : 'password'"
            name="{{ $name }}"
            id="{{ $name }}"
            @class([
                'block w-full rounded-md border px-4 py-2 pr-12 text-base
                placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                'border-red-300' => $errors->has($name),
                'border-slate-300' => !$errors->has($name)
            ])
        >

        <button
            type="button"
            @click="showPassword = !showPassword"
            class="absolute right-3 top-1/2 flex -translate-y-1/2 cursor-pointer items-center justify-center text-slate-500 hover:text-slate-700"
        >
            {{-- Ikona oka --}}
            <svg
                x-show="showPassword==true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
            </svg>

            {{-- Ikona preškrtnutého oka --}}
            <svg
                x-show="showPassword==false"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 002.25 12s3.75 6.75 9.75 6.75c1.747 0 3.286-.428 4.604-1.057M6.228 6.228A10.45 10.45 0 0112 5.25c6 0 9.75 6.75 9.75 6.75a18.683 18.683 0 01-3.217 3.732M6.228 6.228L3 3m3.228 3.228l3.65 3.65m8.654 8.654L21 21m-3.468-3.468l-3.65-3.65m0 0A3 3 0 0110.118 10.12m3.764 3.764L10.118 10.12"
                />
            </svg>
        </button>
    </div>

    @error($name)
    <div class="mt-1 text-sm text-red-500">
        {{ $message }}
    </div>
    @enderror
</div>
