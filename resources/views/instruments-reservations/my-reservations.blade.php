    <x-layout>
        <div class="mx-6 mt-8">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-800">Moje rezervácie nástrojov</h1>
                    <p class="text-sm text-slate-500">Prehľad všetkých Vašich rezervácií nástrojov.</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-300">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Názov nástroja</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Sériové číslo nástroja</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Rezervoval</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Od</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Do</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Popis rezervácie</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Stav</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Zobraziť</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse ($instruments_reservations as $instruments_reservation)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            {{ $instruments_reservation->instrument->manufacturer . ', ' . $instruments_reservation->instrument->model_name }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $instruments_reservation->instrument->serial_number }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $instruments_reservation->reservedBy->name }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $instruments_reservation->from->format('d. m. Y H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $instruments_reservation->to->format('d. m. Y H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $instruments_reservation->description ?? '-'}}
                        </td>
                        <td class="px-4 py-3">
                            {{ $instruments_reservation->status->label() }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('instruments-reservations.show', $instruments_reservation) }}"
                            class="text-blue-800 hover:text-blue-900">
                                Zobraziť
                            </a>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </x-layout>
