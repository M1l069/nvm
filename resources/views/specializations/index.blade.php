<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Špecializácie</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých špecializácií.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <a href="{{ route('specializations.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Pridať špecializáciu
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Názov špecializácie</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Odbor</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Počet študentov na špecializácií</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Zobraziť</th>
                @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                    <th class="px-4 py-3 text-left text-sm font-semibold">Akcie</th>
                @endif
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($specializations as $specialization)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        {{ $specialization->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $specialization->department->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $specialization->students_count }}
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('specializations.show', $specialization) }}" class="text-blue-800 hover:text-blue-900">
                            Zobraziť
                        </a>
                    </td>
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin || (auth()->user()->role === \App\Enums\UserRole::Teacher
                        && auth()->user()->teacher->id === $specialization->department->responsible_teacher_id) && !$specialization->trashed())
                        <td class="px-4 py-3">
                            <a href="{{ route('specializations.edit', $specialization) }}" class="text-blue-800 hover:text-blue-900">
                                Upraviť
                            </a>
                            <form action="{{ route('specializations.destroy', $specialization) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-600 cursor-pointer">
                                    Vymazať
                                </button>
                            </form>
                        </td>
                    @endif
                    @if($specialization->trashed() && auth()->user()->role === \App\Enums\UserRole::Admin)
                        <td class="px-4 py-3">
                            <form action="{{ route('specializations.destroy', $specialization) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="text-blue-800 hover:text-blue-900 cursor-pointer">
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
