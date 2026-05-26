<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4">
    <x-card>
        <div class="flex flex-col gap-4 justify-start">
        <h2 class="text-2xl text-center">Základné informácie</h2>

            <div class="text-base text-slate-300">Meno a Priezvisko: {{ auth()->user()->name }}</div>
            <div>Používateľské meno: {{ request()->user()->username }}</div>
            @if(request()->user()->email)
            <div>E-mail: {{ request()->user()->email }}</div>
            @endif
            @if($user->role === \App\Enums\UserRole::Student)
            <div>Dátum narodenia: {{ $user->student->birth_date->format('d.m.Y') }}</div>
            <div>Bydlisko: {{ $user->student->street }}, {{ $user->student->postal_code }},
                {{ $user->student->city }}, {{ $user->student->country }}
            </div>

            @endif

        </div>
    </x-card>
    </div>
</x-layout>
