<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Udalosti</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých Vašich udalostí.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                <a href="{{ route('events.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Pridať udalosť
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Zodpovedný učiteľ</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Názov udalosti</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Typ udalosti</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Začína</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Končí</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">V miestnosti</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Lokácia</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Kapacita</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Popis udalosti</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Dostupnosť</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Zobraziť</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Akcie o účasti</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($bands as $band)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        {{ $band->teacher->user->name }}
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
