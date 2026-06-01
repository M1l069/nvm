<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Kapely</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých kapiel.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                <a href="{{ route('rooms.reservations.create', $room) }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Rezervovať miestnosť
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Miestnosť</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Rezervoval</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Rezervované od</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Rezervované do</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Popis rezervácie</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Status rezervácie</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Akcie</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">

            @forelse ($roomReservations as $reservation)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        {{ $room->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->reservedBy->user->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->from->format('d. m. Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->to->format('d. m. Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $reservation->description ?? '-' }}
                    </td>
                    @if($reservation->status === true)
                        <td class="px-4 py-3">
                            <p class="text-red-500">
                                Rezervovaná
                            </p>
                        </td>
                    @else
                        <td class="px-4 py-3">
                            <p class="text-green-500">
                                Voľná
                            </p>
                        </td>
                    @endif
                    <td class="px-4 py-3">
                        <a href="{{ route('rooms.reservations.edit', [$room, $reservation]) }}"
                           class="text-blue-800 hover:text-blue-900"> Upraviť rezerváciu </a>
                    </td>
                    <td class="px-4 py-3">
                        <form action="{{ route('rooms.reservations.destroy', [$room, $reservation]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-600">
                                Zrušiť rezerváciu
                            </button>
                        </form>
                    </td>
                </tr>
            @empty

            @endforelse
        </table>
    </div>
</x-layout>
