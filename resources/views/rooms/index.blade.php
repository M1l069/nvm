<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Kapely</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých kapiel.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                <a href="{{ route('rooms.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Pridať miestnosť
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Názov miestnosti</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Popis miestnosti</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Kapacita miestnosti</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Zobraziť</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Akcie</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($rooms as $room)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        {{ $room->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $room->description ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $room->capacity }}
                    </td>

                    <td class="px-4 py-3">
                        <a href="{{ route('rooms.show', $room) }}" class="text-blue-800 hover:text-blue-900">
                            Zobraziť
                        </a>
                    </td>

                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <td class="px-4 py-3">
                    @if(!$room->trashed())
                    <a href="{{ route('rooms.edit', $room) }}"  class="text-blue-800 hover:text-blue-900">
                        Upraviť
                    </a>
                    <form action="{{ route('rooms.destroy', $room) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:text-red-600 cursor-pointer">
                            Vymazať
                        </button>
                    </form>
                    @endif
                @else
                    <form action="{{ route('rooms.destroy', $band) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="cursor-pointer text-sm text-blue-700 hover:text-blue-900">
                            Obnoviť
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
