<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Kapely</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých kapiel.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                <a href="{{ route('bands.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Vytvoriť kapelu
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Zodpovedný učiteľ</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Názov kapely</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Popis kapely</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Kapacita kapely</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Zobraziť</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Akcie</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($bands as $band)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        <a href="{{ route('teachers.show', $band->teacher) }}" class="hover:text-blue-800">
                            {{ $band->teacher->user->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        {{ $band->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $band->description }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $band->students_count }} / {{ $band->capacity }}
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('bands.show', $band) }}" class="text-blue-800 hover:text-blue-900">
                            Zobraziť
                        </a>
                    </td>
                    <td class="px-4 py-3">
                    @if(!$band->trashed() && (auth()->user()->role === \App\Enums\UserRole::Admin || (auth()->user()->role === \App\Enums\UserRole::Teacher &&
                        auth()->user()->teacher?->id === $band->teacher->id)))
                        <a href="{{ route('bands.edit', $band) }}" class="text-blue-800 hover:text-blue-900">
                            Upraviť
                        </a>
                        <form action="{{ route('bands.destroy', $band) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-600 cursor-pointer">
                                Vymazať
                            </button>
                        </form>
                    @endif

                    @if($band->trashed() && auth()->user()->role === \App\Enums\UserRole::Admin )
                        <form action="{{ route('bands.restore', $band->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="cursor-pointer text-sm text-blue-700 hover:text-blue-900">
                                Obnoviť
                            </button>
                        </form>
                    @endif
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
