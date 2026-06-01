<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o rezervácií pre miestnosť {{ Str::lcfirst($room->name) }}
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Rezervoval:</p>
                    <p class="text-slate-800">{{ $reservation->reservedBy->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Popis rezervácie:</p>
                    <p class="text-slate-800">{{ $reservation->description ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Rezervované od:</p>
                    <p class="text-slate-800">{{ $reservation->from->format('d. m. Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Rezervované do:</p>
                    <p class="text-slate-800">{{ $reservation->to->format('d. m. Y H:i') }}</p>
                </div>
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin || (auth()->user()->role === \App\Enums\UserRole::Teacher && auth()->user()->id === $reservation->reservedBy->id))
                <div class="flex justify-end">
                <a href="{{ route('rooms.reservations.edit', [$room, $reservation]) }}"
                class="mt-4 bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                    Upraviť rezerváciu
                </a>
                </div>
                <div class="flex justify-end mt-4">
                    <form action="{{ route('rooms.reservations.destroy', [$room, $reservation]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-black py-2 px-2 rounded-md hover:bg-red-600 cursor-pointer">
                            Zrušiť rezerváciu
                        </button>
                    </form>
                </div>
            @endif
        </x-card>
    </div>
</x-layout>
