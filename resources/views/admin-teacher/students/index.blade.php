<x-layout>
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
                <th class="px-4 py-3 text-left text-sm font-semibold">Mesto</th>
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
                            {{ $guardian->user->name }}
                        @empty
                            -
                        @endforelse
                    </td>
                    <td class="px-4 py-3 text-slate-600">
                        {{ $student->user->email ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $student->phone_number ?? '-' }}
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
                        {{ $student->city }}
                    </td>
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('students.edit', $student) }}" class="text-sm text-blue-700 hover:text-blue-900">
                            Upraviť
                        </a>
                        <a href="{{ route('students.destroy', $student) }}" class="ml-2 text-sm text-red-500 hover:text-red-700">
                            Vymazať
                        </a>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
