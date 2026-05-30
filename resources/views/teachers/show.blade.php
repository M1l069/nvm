<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o učiteľovi
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Meno:</p>
                    <p class="text-slate-800">{{ $teacher->user->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Email:</p>
                    @if($teacher->user->email)
                        <a href="mailto:{{ $teacher->user->email }}" class="text-slate-800 hover:text-blue-800">
                            {{ $teacher->user->email }}
                        </a>
                    @else
                        -
                    @endif
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Používateľské meno:</p>
                    <p class="text-slate-800">{{ $teacher->user->username }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Odbor:</p>
                    <p class="text-slate-800">{{ $teacher->specialization->department->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Špecializácia:</p>
                    <p class="text-slate-800">{{ $teacher->specialization->name }}</p>
                </div>
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                @if(!$teacher->trashed())
                    <div>
                        <div class="flex justify-end">
                            <a href="{{ route('teachers.edit', $teacher) }}" class="bg-yellow-300
                        text-black py-2 px-2 rounded-md hover:bg-yellow-400">Upraviť</a>
                        </div>
                    </div>
                @endif

                <div>
                    <div class="flex justify-end">
                        @if(!$teacher->trashed())
                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-orange-500 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-orange-600 cursor-pointer">
                                    Vymazať
                                </button>
                            </form>
                        @else
                            <form action="{{ route('teachers.restore', $teacher) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="bg-blue-300 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-blue-400 cursor-pointer">
                                    Obnoviť
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </x-card>

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Kapely Učiteľa
            </h2>
            <div class="grid gap-4 sm:grid-cols-2">
                @forelse($teacher->bands as $band)
                    <div>
                        <p class="text-sm font-medium text-slate-500">Meno kapely: </p>
                        <a href="#" class="text-slate-800 hover:text-blue-800">{{ $band->name }}</a> {{--{{ route('bands.show', $band) }}--}}
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500">Popis kapely: </p>
                        <p class="text-slate-800">{{ $band->description }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Kapacita kapely: </p>
                        <p class="text-slate-800">{{ $band->students->count() . '/'. $band->capacity }}</p>
                    </div>
                    @if(!$loop->last)
                        <hr class="col-span-2 border-slate-300">
                    @endif
                @empty
                    <p class="text-slate-500">Učiteľ nemá žiadnu kapelu</p>
                @endforelse
            </div>
        </x-card>
    </div>
</x-layout>
