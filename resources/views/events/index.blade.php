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
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                        <th class="px-4 py-3 text-right text-sm font-semibold">Akcie</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @foreach ($events as $event)
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
                        @if($event->location)
                            <p>
                                {{ $event->location }}
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
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                        <td class="px-4 py-3">
                            @if(!$event->trashed())
                                <a href="{{ route('events.edit', $event) }}" class="text-sm text-blue-700 hover:text-blue-900">
                                    Upraviť
                                </a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="cursor-pointer text-sm text-red-500 hover:text-red-700">
                                        Vymazať
                                    </button>
                                </form>
                            @else
                                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                                    <form action="{{ route('events.restore', $event->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="cursor-pointer text-sm text-blue-700 hover:text-blue-900">
                                            Obnoviť
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
</x-layout>
