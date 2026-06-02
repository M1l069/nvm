<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Odbory</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých odborov.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <a href="{{ route('departments.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Pridať odbor
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Názov odporu</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Popis odboru</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Počet špecializácií</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Zobraziť</th>
                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <th class="px-4 py-3 text-left text-sm font-semibold">Akcie</th>
                @endif
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($departments as $department)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        {{ $department->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $department->description ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $department->specializations_count }}
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('departments.show', $department) }}" class="text-blue-800 hover:text-blue-900">
                            Zobraziť
                        </a>
                    </td>
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        @if(!$department->trashed())
                        <td class="px-4 py-3">
                            <a href="{{ route('departments.edit', $department) }}" class="text-blue-800 hover:text-blue-900">
                                Upraviť
                            </a>
                            <form action="{{ route('departments.destroy', $department) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="cursor-pointer text-red-500 hover:text-red-600">
                                    Vymazať
                                </button>
                            </form>
                        </td>
                            @else
                            <td class="px-4 py-3">
                                <form action="{{ route('departments.restore', $department->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="text-blue-400 hover:text-blue-500 cursor-pointer">
                                        Obnoviť
                                    </button>
                                </form>
                            </td>
                            @endif

                    @endif
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
