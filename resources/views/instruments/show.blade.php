<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o nástroji
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Výrobca nástroja:</p>
                    <p class="text-slate-800">{{ $instrument->manufacturer }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Model nástroja:</p>
                    <p class="text-slate-800">{{ $instrument->model_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Sériové číslo nástroja:</p>
                    <p class="text-slate-800">{{ $instrument->serial_number }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Pre špecializáciu:</p>
                    <p class="text-slate-800">{{ $instrument->specialization->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Uložený v miestnosti:</p>
                    <p class="text-slate-800">{{ $instrument->room->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Dostupnosť nástroja:</p>
                    @if($instrument->is_available)
                        <p class="text-green-500"> Dostupný </p>
                    @else
                        <p class="text-red-500"> Rezervovaný </p>
                    @endif
                </div>
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <div class="flex justify-end">
                    <a href="{{ route('instruments.edit', $instrument) }}" class="mt-4 bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                        Upraviť
                    </a>
                </div>
                <div class="flex justify-end mt-4">
                    <form action="{{ route('instruments.destroy', $instrument) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-black py-2 px-2 rounded-md hover:bg-red-600 cursor-pointer">
                            Vymazať
                        </button>
                    </form>
                </div>
            @endif
            @if($instrument->is_available)
                <div class="flex justify-start">
                    <a href="#" class="mt-4 bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                        Rezervovať
                    </a>
                </div>
            @endif
        </x-card>
    </div>
</x-layout>
