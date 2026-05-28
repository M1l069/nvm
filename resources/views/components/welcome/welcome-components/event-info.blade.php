<div class="rounded-lg border border-slate-200 p-4">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="font-semibold text-slate-900">
                {{ $event->name }}
            </h3>

            <p class="text-sm text-slate-500">
                Kapela: {{ $band->name ?? 'Neuvedené' }}
            </p>

            <p class="text-sm text-slate-500">
                Typ: {{ $event->type->label() ?? 'Neuvedené' }}
            </p>
            @if($event->room)
            <p class="text-sm text-slate-500">
                Miestnosť: {{ $event->room->name }}
            </p>
            @endif
            <p class="text-sm text-slate-500">
                Popis udalosti: {{ $event->description }}
            </p>
            <p @class(['text-sm','text-green-500' => $event->is_public === true, 'text-red-500' => $event->is_public === false])>
                {{ $event->is_public ? 'Verejné' : 'Neverejné' }}
            </p>
        </div>

        <div class="text-sm text-slate-600">
            Začína {{ $event->starts_at?->diffForHumans() ?? 'Neuvedené' }}
            <br>
            Končí {{ $event->ends_at?->diffForHumans() }}
        </div>
    </div>
</div>
