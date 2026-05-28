{{-- Ľavý / hlavný stĺpec --}}
<div class="space-y-6 lg:col-span-2">
    <x-welcome.welcome-window section-name="Koncerty kapiel">
        @forelse($user->guardian->students as $student)
            @forelse($student->bands as $band)
                <p class="text-sm text-slate-500">
                    Pozícia v kapele {{ Str::lcfirst($band->name) }}:
                    {{ Str::ucfirst($student->specialization->name) }}
                </p>
                @forelse($band->events as $event)
                    <x-welcome.welcome-components.event-info :$band :$event/>
                @empty
                    <p class="text-sm text-slate-500">Žiadne udalosti žiakových kapiel</p>
                @endforelse
            @empty
                <p class="text-sm text-slate-500">
                    Nie sú dostupné žiadne udalosti kapiel.
                </p>
            @endforelse
        @empty
        @endforelse
    </x-welcome.welcome-window>
    <x-welcome.welcome-window section-name="Moje Registrované udalosti">
        @forelse($user->guardian->user->events as $event)
            <x-welcome.participant-events :$event/>
        @empty
            <p class="text-sm text-slate-500">
                Nie ste registrovaný na žiadnu udalosť.
            </p>
        @endforelse
    </x-welcome.welcome-window>

    {{-- Známky --}}
    <section class="rounded-xl bg-white p-6 shadow-md border border-slate-100">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-slate-900">
                Známky
            </h2>

            <x-welcome.welcome-components.view-all-link href="#"/>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200">
            <div
                class="hidden grid-cols-4 bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600 sm:grid">
                <div>Predmet</div>
                <div>Hodnotenie</div>
                <div>Dátum</div>
                <div>Poznámka</div>
            </div>

            <div class="divide-y divide-slate-200">
                @forelse($grades ?? [] as $grade)
                    <div class="grid gap-1 px-4 py-3 text-sm sm:grid-cols-4 sm:gap-4">
                        <div>
                            <span class="font-medium text-slate-500 sm:hidden">Predmet: </span>
                            {{ $grade->subject?->name ?? 'Neuvedené' }}
                        </div>

                        <div class="font-semibold text-slate-900">
                            <span class="font-medium text-slate-500 sm:hidden">Hodnotenie: </span>
                            {{ $grade->value ?? $grade->grade }}
                        </div>

                        <div>
                            <span class="font-medium text-slate-500 sm:hidden">Dátum: </span>
                            {{ $grade->created_at?->format('d.m.Y') }}
                        </div>

                        <div class="text-slate-600">
                            <span class="font-medium text-slate-500 sm:hidden">Poznámka: </span>
                            {{ $grade->note ?? '-' }}
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-3 text-sm text-slate-500">
                        Nie sú dostupné žiadne známky.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

<aside class="space-y-6">
    @forelse($user->guardian->students as $student)
        {{-- Pravý bočný stĺpec --}}
        {{-- Kapely --}}
        <x-welcome.welcome-components.side-window section-name="Kapely">
            @forelse($student->bands as $band)
                <div class="rounded-lg border border-slate-200 p-4">
                    <h3 class="font-semibold text-slate-900">
                        {{ $band->name }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Počet udalostí: {{ $band->events->count() }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-slate-500">
                    Žiadne kapely neboli nájdené.
                </p>
            @endforelse

        </x-welcome.welcome-components.side-window>

        {{-- GradeEventy --}}
        <x-welcome.welcome-components.side-window section-name="Písomky/Testy">
            @forelse($gradeEvents ?? [] as $gradeEvent)
                <div class="rounded-lg border border-slate-200 p-4">
                    <h3 class="font-semibold text-slate-900">
                        {{ $gradeEvent->name ?? $gradeEvent->title }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $gradeEvent->date?->format('d.m.Y') ?? 'Dátum neuvedený' }}
                    </p>

                    @if($gradeEvent->description ?? false)
                        <p class="mt-2 text-sm text-slate-600">
                            {{ $gradeEvent->description }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-slate-500">
                    Nie sú dostupné žiadne hodnotiace udalosti.
                </p>
            @endforelse
        </x-welcome.welcome-components.side-window>
    @empty

    @endforelse
</aside>
