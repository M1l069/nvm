<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Rezervácie nástrojov</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých rezervácií nástrojov.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <a href="{{ route('instruments-reservations.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Vytvoriť rezerváciu nástroja
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Sériové číslo nástroja</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Rezervoval</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Rezervované pre</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Rezervované od</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Rezervované do</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Popis rezervácie</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Stav rezervácie</th>
                @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                    <th class="px-4 py-3 text-left text-sm font-semibold">Akcie</th>
                @endif
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($reservations as $reservation)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        {{ $reservation->instrument->serial_number }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->reservedBy->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->reservedFor->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->from->format('d. m. Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->to->format('d. m. Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->description ?? '-'}}
                    </td>
                    <td class="px-4 py-3">
                        @switch($reservation->status)
                            @case(\App\Enums\InstrumentReservationStatus::Active)
                                <p class="text-green-500">{{ $reservation->status->label() }}</p>
                                @break
                            @case(\App\Enums\InstrumentReservationStatus::Overdue)
                                <p class="text-red-500">{{ $reservation->status->label() }}</p>
                                @break
                            @case(\App\Enums\InstrumentReservationStatus::Completed)
                                <p class="text-green-500">{{ $reservation->status->label() }}</p>
                                @break
                        @endswitch
                    </td>
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                        <td class="px-4 py-3">
                            <a href="{{ route('instruments-reservations.show', $reservation) }}"
                            class="text-blue-800 hover:text-blue-900">
                                Zobraziť
                            </a>

                            <form action="{{ route('instruments-reservations.destroy', $reservation) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-600 cursor-pointer">
                                    Zrušiť rezerváciu
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
