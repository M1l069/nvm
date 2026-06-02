<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o špecializácií
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Názov špecializácie:</p>
                    <p class="text-slate-800">{{ $specialization->name }}</p>
                </div>
                <div>
                   <p class="text-sm font-medium text-slate-500"> Odbor:</p>
                    <p class="text-slate-800">{{ $specialization->department->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500"> Zodpovedný učiteľ za odbor:</p>
                    <p class="text-slate-800">{{ $specialization->department->responsibleTeacher->user->name }}</p>
                </div>
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin ||
            (auth()->user()->role === \App\Enums\UserRole::Teacher && auth()->user()->teacher->id === $specialization->department->responsible_teacher_id))
                @if(!$specialization->trashed())
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('specializations.edit', $specialization) }}" class="bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            Upraviť
                        </a>
                    </div>
                    <div class="flex justify-end mt-4">
                        <form action="{{ route('specializations.destroy', $specialization) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-black py-2 px-2 rounded-md hover:bg-red-600 cursor-pointer">
                                Vymazať
                            </button>
                        </form>
                    </div>
                @endif
            @endif
            @if($specialization->trashed())
                <div class="flex justify-end mt-4">
                    <form action="{{ route('departments.restore', $department->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="bg-blue-300 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-blue-400 cursor-pointer">
                            Obnoviť
                        </button>
                    </form>
                </div>
            @endif
        </x-card>
    </div>
</x-layout>
