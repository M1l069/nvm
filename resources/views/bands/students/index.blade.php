<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Kapely</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých kapiel.</p>
            </div>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin || (auth()->user()->role === \App\Enums\UserRole::Teacher && auth()->user()->teacher->id === $band->teacher_id))
                <a href="{{ route('bands.students.create', $band) }}"
                   class="rounded-md bg-yellow-300 px-4 py-2 text-sm font-medium text-black shadow-sm hover:bg-yellow-400">
                    + Pridať študenta do kapely
                </a>
            @endif
        </div>
    </div>
    @php $user = auth()->user() @endphp
    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Meno žiaka</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Pozícia žiaka</th>
                @if($user->role === \App\Enums\UserRole::Admin || ($user->role === \App\Enums\UserRole::Teacher && $user->teacher->id === $band->teacher_id))
                <th class="px-4 py-3 text-left text-sm font-semibold">Akcie</th>
                @endif
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($students as $student)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">{{ $student->user->name }}</td>
                    <td class="px-4 py-3">{{ $student->specialization->name }}</td>
                    @if(!$student->trashed() && $user->role === \App\Enums\UserRole::Admin || ($user->role === \App\Enums\UserRole::Teacher && $user->teacher->id === $band->teacher_id))
                        <td class="px-4 py-3">
                            <form action="{{ route('bands.students.destroy', [$band, $student]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text_red-600 cursor-pointer">
                                    Odstrániť z kapely
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
