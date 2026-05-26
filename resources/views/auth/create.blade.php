<x-layout>
    <div class="flex items-center justify-center px-4 py-10 sm:items-center sm:py-16">
        <article class="w-full max-w-lg rounded-xl border border-slate-300 bg-white p-6 shadow-md sm:p-8">
            <h1 class="mb-8 text-center text-3xl font-semibold sm:text-4xl">Prihlásenie</h1>

            <form action="{{ route('auth.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="mb-2 block font-medium text-slate-700">
                        Používateľské meno <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="username"
                        id="username"
                        @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('username'),
                        'border-slate-300' => !$errors->has('username')])>
                    @error('username')
                    <div class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div x-data="{ showPassword: false }">
                    <div class="relative mt-2">
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                        Heslo <span class="text-red-500">*</span>
                    </label>

                    <input
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        id="password"
                        @class(['w-full rounded-md border px-4 py-2 pr-10 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('password'),
                        'border-slate-300' => !$errors->has('password')])>
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-12 right-0 flex items-center px-3 cursor-pointer"
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
                        @error('password')
                        <div class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button
                        type="submit"
                        class="w-full cursor-pointer rounded-md bg-yellow-300 px-4 py-3 font-medium text-black shadow-md hover:bg-yellow-500 sm:w-auto sm:px-6"
                    >
                        Prihlásiť sa
                    </button>
                </div>
            </form>
        </article>
    </div>
</x-layout>
