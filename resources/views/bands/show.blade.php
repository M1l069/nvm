<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o kapele {{ Str::lcfirst($band->name) }}
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Názov kapely:</p>
                    <p class="text-slate-800">{{ $band->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Učiteľ zodpovedný za kapelu:</p>
                    <p class="text-slate-800">{{ $band->teacher->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Kapacita kapely:</p>
                    <p class="text-slate-800">{{ $band->students_count ?? 0 }} / {{ $band->capacity }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Popis kapely:</p>
                    <p class="text-slate-800">{{ $band->description }}</p>
                </div>
            </div>
            <div class="flex justify-start mt-4">
                <a href="{{ route('bands.students.index', $band) }}" class="bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400 cursor-pointer">
                    Zobraziť členov
                </a>
            </div>
            @if(!$band->trashed() && (auth()->user()->role === \App\Enums\UserRole::Admin ||
        (auth()->user()->role === \App\Enums\UserRole::Teacher && $band->teacher_id === auth()->user()->teacher->id)))
            <div class="flex justify-end mt-4">
                <a href="{{ route('bands.edit', $band) }}" class="bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400 cursor-pointer">
                    Upraviť
                </a>
            </div>
            <div class="flex justify-end mt-4">
                <form action="{{ route('bands.destroy', $band) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500
                                    text-black py-2 px-2 rounded-md hover:bg-red-600 cursor-pointer">
                        Vymazať
                    </button>
                </form>
            </div>
            @else
                <form action="{{ route('bands.restore', $band->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="bg-blue-300 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-blue-400 cursor-pointer">
                        Obnoviť
                    </button>
                </form>
            @endif

        </x-card>
    </div>
</x-layout>
