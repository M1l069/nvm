<div class="space-y-6 lg:col-span-2">
    <x-welcome.welcome-window section-name="Koncerty kapiel">
        @forelse($bands ?? [] as $band)
            @forelse($band->events as $event)
                <x-welcome.welcome-components.event-info :$event :$band/>
            @empty
                <p class="text-sm text-slate-500">Kapela nemá žiadne udalosti</p>
            @endforelse
        @empty
            <p class="text-sm text-slate-500">Neexistujú žiadne kapely</p>
        @endforelse
    </x-welcome.welcome-window>

    <x-welcome.welcome-window section-name="Udalosti">
        @forelse($events as $userEvent)
            <x-welcome.participant-events :event="$userEvent" />
        @empty
            <p class="text-sm text-slate-500">
                Neexistujú žiadne udalosti
            </p>

        @endforelse
    </x-welcome.welcome-window>
</div>
<aside class="space-y-6">
    <x-welcome.welcome-components.side-window section-name="Kapely">
        @forelse($bands as $band)
            <div class="rounded-lg border border-slate-200 p-4">
                <h3 class="font-semibold text-slate-900">
                    {{ $band->name }}
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Počet udalostí: {{ $band->events->count() }}
                </p>
            </div>
        @empty
            <p class="text-sm text-slate-500">Nie sú žiadne kapely</p>
        @endforelse
    </x-welcome.welcome-components.side-window>

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
</aside>
