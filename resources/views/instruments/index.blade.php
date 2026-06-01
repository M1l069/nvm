<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Nástroje</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých nástrojov.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <a href="{{ route('instruments.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Pridať nástroj
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Výrobca nástroja</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Názov modelu nástroja</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Sériové číslo</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Špecializácia</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Uložený v</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Dostupnosť</th>
                @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                    <th class="px-4 py-3 text-left text-sm font-semibold">Zobraziť</th>
                @endif
                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <th class="px-4 py-3 text-left text-sm font-semibold">Akcie</th>
                @endif
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($instruments as $instrument)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        {{ $instrument->manufacturer }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $instrument->model_name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $instrument->serial_number }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $instrument->specialization->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $instrument->room->name }}
                    </td>
                    <td class="px-4 py-3">
                        @if($instrument->is_available)
                            <p class="text-green-500">
                                Dostupný
                            </p>
                        @else
                            <p class="text-red-500">
                                Rezervovaný
                            </p>
                        @endif
                    </td>
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                        <td class="px-4 py-3">
                            <a href="{{ route('instruments.show', $instrument) }}" class="text-blue-800 hover:text-blue-900">
                                Zobraziť
                            </a>
                        </td>
                    @endif
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        <td class="px-4 py-3">
                            <a href="{{ route('instruments.edit', $instrument) }}" class="text-blue-800 hover:text-blue-900">
                                Upraviť
                            </a>
                            <form action="{{ route('instruments.destroy', $instrument) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-500 cursor-pointer">
                                    Vymazať
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
