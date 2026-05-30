<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o učiteľovi
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Meno:</p>
                    <p class="text-slate-800">{{ $teacher->user->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Email:</p>
                    @if($teacher->user->email)
                        <a href="mailto:{{ $teacher->user->email }}" class="text-slate-800 hover:text-blue-800">
                            {{ $teacher->user->email }}
                        </a>
                    @else
                        -
                    @endif
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Používateľské meno:</p>
                    <p class="text-slate-800">{{ $teacher->user->username }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Odbor:</p>
                    <p class="text-slate-800">{{ $teacher->specialization->department->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Špecializácia:</p>
                    <p class="text-slate-800">{{ $teacher->specialization->name }}</p>
                </div>
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                @if(!$teacher->trashed())
                    <div>
                        <div class="flex justify-end">
                            <a href="{{ route('teachers.edit', $teacher) }}" class="bg-yellow-300
                        text-black py-2 px-2 rounded-md hover:bg-yellow-400">Upraviť</a>
                        </div>
                    </div>
                @endif

                <div>
                    <div class="flex justify-end">
                        @if(!$teacher->trashed())
                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-orange-500 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-orange-600 cursor-pointer">
                                    Vymazať
                                </button>
                            </form>
                        @else
                            <form action="{{ route('teachers.restore', $teacher) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="bg-blue-300 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-blue-400 cursor-pointer">
                                    Obnoviť
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </x-card>

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Kapely Učiteľa
            </h2>
            <div class="grid gap-4 sm:grid-cols-2">
                @forelse($teacher->bands as $band)
                    <div>
                        <p class="text-sm font-medium text-slate-500">Meno kapely: </p>
                        <a href="#" class="text-slate-800 hover:text-blue-800">{{ $band->name }}</a> {{--{{ route('bands.show', $band) }}--}}
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500">Popis kapely: </p>
                        <p class="text-slate-800">{{ $band->description }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Kapacita kapely: </p>
                        <p class="text-slate-800">{{ $band->students->count() . '/'. $band->capacity }}</p>
                    </div>
                    @if(!$loop->last)
                        <hr class="col-span-2 border-slate-300">
                    @endif
                @empty
                    <p class="text-slate-500">Učiteľ nemá žiadnu kapelu</p>
                @endforelse

            </div>

        </x-card>

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Rezervácie nástrojov
            </h2>

            <div class="space-y-4">
                @forelse($teacher->user->instrumentReservations as $reservation)
                    <div class="rounded-lg border border-slate-200 p-4">
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Nástroj:
                            </p>
                            <a href="#" class="font-medium text-slate-800 hover:text-blue-800"> {{--{{ route('instruments.reservations.show', $reservation) }}--}}
                                {{ $reservation->instrument->name }}
                            </a>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Rezervované od:
                            </p>
                            <p class="font-medium text-slate-800">
                                {{ $reservation->from->format('d. m. Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Rezervované do:
                            </p>
                            <p class="font-medium text-slate-800">
                                {{ $reservation->to->format('d. m. Y. H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Rezervované pre:
                            </p>
                            <p class="font-medium text-slate-800">
                                {{ $reservation->reservedFor->user->name }}
                            </p>
                        </div>
                        @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->id === $reservation->reservedBy()->user->id)
                            <a href="#" class="bg-yellow-300 text-black py-2 px-2 rounded-md">Upraviť</a> {{--instruments.reservations.edit--}}
                        @endif
                    </div>
                @empty
                    <p class="text-slate-500">Učiteľ nerezervoval žiadne nástroje.</p>
                @endforelse

            </div>
        </x-card>

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Rezervácie miestností
            </h2>

            <div class="space-y-4">
                @forelse($teacher->user->roomReservations as $roomReservation)
                    <div class="rounded-lg border border-slate-200 p-4">
                        <a href="#" class="font-medium text-slate-800 hover:text-blue-800"> {{--{{ route('instruments.reservations.show', $reservation) }}--}}
                            {{ $roomReservation->room->name }}
                        </a>
                        <p class="font-medium text-slate-800">
                            {{ $reservation->reservedFor->user->name }}
                        </p>
                        @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->id === $reservation->reservedBy()->user->id)
                            <a href="#" class="bg-yellow-300 text-black py-2 px-2 rounded-md">Upraviť</a> {{--instruments.reservations.edit--}}
                        @endif
                    </div>
                @empty
                    <p class="text-slate-500">Učiteľ nerezervoval žiadnu miestnosť.</p>
                @endforelse

            </div>
        </x-card>

    </div>
</x-layout>
