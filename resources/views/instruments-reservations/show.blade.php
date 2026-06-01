<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o rezervácií
                nástroja {{ $instruments_reservation->instrument->manufacturer }} {{ $instruments_reservation->instrument->model_name }} {{ $instruments_reservation->instrument->serial_number }}
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Výrobca nástroja:</p>
                    <p class="text-slate-800">{{ $instruments_reservation->instrument->manufacturer }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Model nástroja:</p>
                    <p class="text-slate-800">{{ $instruments_reservation->instrument->model_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Sériové číslo nástroja:</p>
                    <p class="text-slate-800">{{ $instruments_reservation->instrument->serial_number }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Rezervoval:</p>
                    <p class="text-slate-800">{{ $instruments_reservation->reservedBy->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Rezervované pre:</p>
                    <p class="text-slate-800">{{ $instruments_reservation->reservedFor->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Rezervované od:</p>
                    <p class="text-slate-800">{{ $instruments_reservation->from->format('d.m.Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Rezervované do:</p>
                    <p class="text-slate-800">{{ $instruments_reservation->to->format('d.m.Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Popis rezervácie:</p>
                    <p class="text-slate-800">{{ $instruments_reservation->description ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Stav rezervácie</p>
                    @switch($instruments_reservation->status)
                        @case(\App\Enums\InstrumentReservationStatus::Active)
                            <p class="text-green-500">{{ $instruments_reservation->status->label() }}</p>
                            @break
                        @case(\App\Enums\InstrumentReservationStatus::Overdue)
                            <p class="text-red-500">{{ $instruments_reservation->status->label() }}</p>
                            @break
                        @case(\App\Enums\InstrumentReservationStatus::Completed)
                            <p class="text-green-500">{{ $instruments_reservation->status->label() }}</p>
                            @break
                    @endswitch
                </div>
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin ||
            (auth()->user()->role === \App\Enums\UserRole::Teacher &&
            auth()->user()->id === $instruments_reservation->reserved_by))
                @if(\App\Enums\InstrumentReservationStatus::Active)
                    <div class="col-span-2 flex justify-end">
                        <a href="{{ route('instruments-reservations.edit', $instruments_reservation) }}"
                           class="mt-4 bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            Upraviť rezerváciu
                        </a>
                    </div>
                @endif
                <div class="col-span-2 flex justify-end">
                    <form action="{{ route('instruments-reservations.destroy', $instruments_reservation) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="mt-4 bg-red-500 text-black py-2 px-2 rounded-md hover:bg-red-600 cursor-pointer">
                            Zrušiť rezerváciu
                        </button>
                    </form>
                </div>
            @endif
        </x-card>
    </div>
</x-layout>
