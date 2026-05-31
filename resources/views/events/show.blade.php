<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o udalosti {{ Str::lcfirst($event->name) }}
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Názov udalosti:</p>
                    <p class="text-slate-800">{{ $event->name }}</p>
                </div>
                @if($event->room)
                    <div>
                        <p class="text-sm font-medium text-slate-500">V miestnosti:</p>
                        <p class="text-slate-800">{{ $event->room_id->name }}</p>
                    </div>
                @else
                    <div>
                        <p class="text-sm font-medium text-slate-500">Na mieste:</p>
                        <p class="text-slate-800">{{ $event->street }}, {{ $event->city }}, {{ $event->postal_code }}, {{$event->country }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-sm font-medium text-slate-500">Začína:</p>
                    <p class="text-slate-800">{{ $event->starts_at->format('d. m. Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Končí:</p>
                    <p class="text-slate-800">{{ $event->ends_at->format('d. m. Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Kapacita:</p>
                    <p class="text-slate-800">{{ $participantsCount }} / {{ $event->capacity }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Popis udalosti:</p>
                    <p class="text-slate-800">{{ $event->description ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Prístupné pre verejnosť:</p>
                    @if($event->is_public)
                        <p class="text-green-500">Verejné</p>
                    @else
                        <p class="text-red-500">Neverejné</p>
                    @endif
                </div>
                @if($participantsCount < $event->capacity)
                    <div class="col-span-2 flex justify-end">
                        <a href="{{ route('events.participants.store', $event) }}" class="bg-yellow-300
                                text-black py-2 px-2 rounded-md hover:bg-yellow-400">Zúčastniť sa</a>
                    </div>
                @endif
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                @if(!$event->trashed())
                    <div class="flex justify-end">
                        <a href="{{ route('events.edit', $event) }}" class="bg-yellow-300
                            text-black py-2 px-2 rounded-md hover:bg-yellow-400">Upraviť </a>
                    </div>
                    <div class="flex justify-end">
                        <form action="{{ route('events.destroy', $event) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-orange-500 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-orange-600 cursor-pointer">
                                Vymazať
                            </button>
                        </form>
                    </div>
                @else
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        <div class="flex justify-end">
                            <form action="{{ route('events.restore', $event->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="bg-blue-300 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-blue-400 cursor-pointer">
                                    Obnoviť
                                </button>
                            </form>
                        </div>
                    @endif
                @endif
            @endif

        </x-card>
    </div>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">
        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Vystupujúce kapely
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                @forelse($event->bands as $band)
                    <div>
                        <p class="text-sm font-medium text-slate-500">Kapela:</p>
                        <p class="text-slate-800">{{ $band->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Popis kapely:</p>
                        <p class="text-slate-800">{{ $band->description }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Kapacita kapely:</p>
                        <p class="text-slate-800">{{ $band->students()->count() }} / {{ $band->capacity }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Učiteľ zodpovedný za kapelu:</p>
                        <a href="{{ route('teachers.show', $band->teacher) }}" class="text-slate-800 hover:text-blue-800">{{ $band->teacher->user->name }}</a>
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <a href="#" class="bg-yellow-300  {{-- {{ route('bands.show', $band) }} --}}
                        text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            Zobraziť
                        </a>
                    </div>
                    @if(!$loop->last)
                        <hr class="border-slate-300 col-span-2">
                    @endif
                @empty
                    <p class="text-slate-800">Na udalosti nevystupujú kapely</p>
                @endforelse
            </div>
        </x-card>
    </div>
</x-layout>
