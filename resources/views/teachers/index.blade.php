<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Učitelia</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých evidovaných učiteľov.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <a href="{{ route('teachers.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Pridať učiteľa
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Meno učiteľa</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Email učiteľa</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Odbor</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Špecializácia</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Kapely učiteľa</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Zobraziť</th>
                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <th class="px-4 py-3 text-right text-sm font-semibold">Akcie</th>
                @endif
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($teachers as $teacher)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <a href="{{ route('teachers.show', $teacher) }}" class="hover:text-blue-800">
                            {{ $teacher->user->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <a href="mailto:{{ $teacher->user->email }}" class="hover:text-blue-800">{{ $teacher->user->email ?? '-' }}</a>
                        </td>
                        <td class="px-4 py-3">
                            {{ $teacher->specialization->department->name }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $teacher->specialization->name }}
                        </td>
                        <td class="px-4 py-3">
                            @forelse($teacher->bands as $band)
                                {{ $band->name }}
                            @empty
                                -
                            @endforelse
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('teachers.show', $teacher) }}" class="text-blue-800 hover:text-blue-900">
                                Zobraziť
                            </a>
                        </td>
                        @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                            <td class="px-4 py-3">
                                @if(!$teacher->trashed())
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="text-sm text-blue-700 hover:text-blue-900">
                                        Upraviť
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="cursor-pointer text-sm text-orange-500 hover:text-orange-700">
                                            Vymazať
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('teachers.restore', $teacher->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="cursor-pointer text-sm text-blue-700 hover:text-blue-900">
                                            Obnoviť
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
