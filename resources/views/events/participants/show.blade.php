<x-layout>
    <div class="mx-6 mt-8">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Účastníci udalosti {{ $event->name }}</h1>
                <p class="text-sm text-slate-500">Prehľad všetkých zúčastnených na udalosti {{ $event->name }}</p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm mt-8 mx-4">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-300">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Meno zúčastneného</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Názov udalosti</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Popis udalosti</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Potvrdil účasť</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Zrušiť účasť</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($participants as $participant)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">{{ $participant->name }}</td>
                    <td class="px-4 py-3">{{ $event->name }}</td>
                    <td class="px-4 py-3">{{ $event->description ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $participant->pivot->created_at->format('d. m. Y H:i') }}</td>
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin||
 (auth()->user()->role === \App\Enums\UserRole::Teacher && auth()->user()->teacher->id === $event->teacher_id))
                        <td class="px-4 py-3">
                            <form action="{{ route('events.participants.destroy-participant', [$event, $participant]) }}"
                            method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-600 cursor-pointer">
                                    Zrušiť účasť
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
