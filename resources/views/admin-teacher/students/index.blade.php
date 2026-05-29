<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Žiaci</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých evidovaných žiakov.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <a href="{{ route('students.create') }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Pridať žiaka
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Meno žiaka</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Meno rodiča</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Email žiaka</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Tel.č. žiaka</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Odbor</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Špecializácia</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Dátum narodenia</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Bydlisko</th>
                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <th class="px-4 py-3 text-right text-sm font-semibold">Akcie</th>
                @endif
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            @foreach ($students as $student)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        <a href="{{ route('students.show', $student) }}" class=" hover:text-blue-700">
                            {{ $student->user->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        @forelse($student->guardians as $guardian)
                            <a href="{{ route('students.guardians.show', ['student' => $student, 'guardian' => $guardian]) }}" class="hover:text-blue-700">
                            {{ $guardian->user->name }}
                            </a>
                        @empty
                            -
                        @endforelse
                    </td>
                    <td class="px-4 py-3 text-slate-600">
                        {{ $student->user->email ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $student->phone_number ? phone($student->phone_number)->formatInternational() : '-' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $student->specialization->department->name?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $student->specialization->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $student->birth_date->format('d. m. Y') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $student->street }}, {{ $student->postal_code }}  {{ $student->city }}, {{ $student->country }}
                    </td>
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <td class="px-4 py-3 text-right">
                        @if(!$student->trashed())
                            <a href="{{ route('students.edit', $student) }}" class="text-sm text-blue-700 hover:text-blue-900">
                                Upraviť
                            </a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        <button class="cursor-pointer text-sm text-orange-500 hover:text-orange-700">
                            Vymazať
                        </button>
                        </form>
                        @else
                            <form action="{{ route('students.restore', $student->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="cursor-pointer text-sm text-blue-700 hover:text-blue-900">
                                    Obnoviť
                                </button>
                            </form>

                            <form action="{{ route('students.forceDelete', $student->id) }}" method="POST"
                                  onsubmit="return confirm('Naozaj chcete žiaka trvalo vymazať ? Táto akcia sa nedá vrátiť späť.')">
                                @csrf
                                @method('DELETE')
                                <button class="cursor-pointer text-sm text-orange-500 hover:text-orange-700">
                                    Trvalo vymazať
                                </button>
                            </form>
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
