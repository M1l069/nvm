<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o miestnosti {{ Str::lcfirst($room->name) }}
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Názov miestnosti:</p>
                    <p class="text-slate-800">{{ $room->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Popis miestnosti:</p>
                    <p class="text-slate-800">{{ $room->description ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Kapacita miestnosti:</p>
                    <p class="text-slate-800">{{ $room->capacity }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Dostupnosť miestnosti na rezervovanie:</p>
                    @if($isReserved)
                        <p class="text-red-500">
                            Rezervovaná
                        </p>
                    @else
                        <p class="text-green-600">
                            Dostupná
                        </p>
                    @endif
                </div>
                @if($activeEvent)
                    <div>
                        <p class="font-medium text-red-500">Miestnosť je obsadená udalosťou:</p>
                        <a href="{{ route('events.show', $activeEvent) }}">{{ $activeEvent->name }}</a>
                        <p>
                            {{ $activeEvent->starts_at->format('d.m.Y H:i') }}
                            -
                            {{ $activeEvent->ends_at->format('d.m.Y H:i') }}
                        </p>
                        <p>
                            Zodpovedný učiteľ:
                            {{ $activeEvent->responsibleTeacher?->user?->name ?? '-' }}
                        </p>
                    </div>
                    <div class="col-span-2 flex justify-start">
                        <a href="{{ route('events.show', $activeEvent) }}" class="mt-4 bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            Zobraziť udalosť
                        </a>
                    </div>
                @endif
                @if($activeReservation)
                    <div>
                        <p class="font-medium text-red-500">Miestnosť je rezervovaná:</p>
                        <p>
                            {{ $activeReservation->from->format('d.m.Y H:i') }}
                            -
                            {{ $activeReservation->to->format('d.m.Y H:i') }}
                        </p>
                        <p>
                            Rezervoval:
                            {{ $activeReservation->reservedBy->name }}
                        </p>
                    </div>
                    <div class="col-span-2 flex justify-start">
                        <a href="{{ route('rooms.reservations.show', [$room, $activeReservation]) }}" class="mt-4 bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            Zobraziť udalosť
                        </a>
                    </div>
                @endif
                @if(!$room->trashed() && auth()->user()->role === \App\Enums\UserRole::Admin)
                    <div class="col-span-2 flex justify-end">
                        <a href="{{ route('rooms.edit', $room) }}" class="mt-4 bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            Upraviť
                        </a>
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <form action="{{ route('rooms.destroy', $room) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-black py-2 px-2 rounded-md hover:bg-red-600 cursor-pointer">
                                Vymazať
                            </button>
                        </form>
                    </div>
                @endif
                <div class="col-span-2 flex justify-end">
                    <a href="{{ route('rooms.reservations.index', $room) }}" class="mt-4 bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                        Zobraziť rezervácie miestnosti
                    </a>
                </div>
            </div>
        </x-card>
    </div>
</x-layout>
