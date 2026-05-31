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
            @forelse ($events as $event)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        <a href="{{ route('teachers.show', $event->responsibleTeacher) }}" class="hover:text-blue-800">
                            {{ $event->responsibleTeacher->user->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('events.show', $event) }}" class="hover:text-blue-800">
                            {{ $event->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <p>
                            {{ $event->type->label() }}
                        </p>
                    </td>
                    <td class="px-4 py-3">
                        <p>
                            {{ $event->starts_at->format('d. m. Y H:i') }}
                        </p>
                    </td>
                    <td class="px-4 py-3">
                        <p>
                            {{ $event->ends_at->format('d. m. Y H:i') }}
                        </p>
                    </td>
                    <td class="px-4 py-3">
                        @if($event->room)
                            <p>
                                {{ $event->room->name }}
                            </p>
                        @else
                            <p>
                                -
                            </p>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if(!$event->room)
                            <p>
                                {{ $event->street }}, {{ $event->city }}, {{ $event->postal_code }}, {{ $event->country }}
                            </p>
                        @else
                            <p>
                                -
                            </p>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <p>
                            {{ $event->participants_count ?? 0 }} / {{ $event->capacity }}
                        </p>
                    </td>
                    <td class="px-4 py-3">
                        <p>
                            {{ $event->description ?? '-' }}
                        </p>
                    </td>
                    <td class="px-4 py-3">
                        @if($event->is_public)
                            <p class="text-green-500">
                                Verejná udalosť
                            </p>

                        @else
                            <p class="text-red-500">
                                Neverejná udalosť
                            </p>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('events.show', $event) }}" class="text-blue-700 hover:underline">Zobraziť</a>
                    </td>
                    @if($event->is_public)
                        <td class="px-4 py-3">
                            @if($event->participants->count() < $event->capacity && !$event->participants->contains('id', auth()->id()))
                                <form action="{{ route('events.participants.store', $event) }}" method="POST">
                                    @csrf
                                      <button class="text-blue-700 hover:text-blue-900 cursor-pointer">
                                        Zúčastniť sa
                                      </button>
                                </form>
                            @endif

                            @if($event->participants->contains('id', auth()->id()))
                                <form action="{{ route('events.participants.destroy', $event) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-700 hover:text-red-900 cursor-pointer">
                                        Odhlásiť sa
                                    </button>
                                </form>
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
            @endforelse
            </tbody>

        </table>
    </div>
</x-layout>
