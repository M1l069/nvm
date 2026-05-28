<div class="rounded-lg border border-slate-200 p-4">
    <h3 class="font-semibold text-slate-900">
        {{ $event->name }}
    </h3>

    <div class="mt-1 text-sm text-slate-500">
        {{ $event->starts_at->format('d.m.Y H:i') }}
        -
        {{ $event->ends_at->format('d.m.Y H:i') }}
    </div>

    @if($event->description)
        <p class="mt-2 text-sm text-slate-600">
            {{ $event->description }}
        </p>
    @endif
</div>


