<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o žiakovi
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-slate-500">Meno:</p>
                    <p class="text-slate-800">{{ $student->user->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Email:</p>
                    <p class="text-slate-800">{{ $student->user->email ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Používateľské meno:</p>
                    <p class="text-slate-800">{{ $student->user->username }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Dátum narodenia:</p>
                    <p class="text-slate-800">{{ $student->birth_date->format('d.m.Y') }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Tel. č. :</p>
                    <p class="text-slate-800">{{ $student->phone_number ?? '-' }}</p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-sm font-medium text-slate-500">Bydlisko:</p>
                    <p class="text-slate-800">
                        {{ $student->street }}, {{ $student->postal_code }}
                        {{ $student->city }}, {{ $student->country }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Odbor:</p>
                    <p class="text-slate-800">{{ $student->specialization->department->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">Špecializácia:</p>
                    <p class="text-slate-800">{{ $student->specialization->name }}</p>
                </div>
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                @if(!$student->trashed())
                <div>
                    <div class="flex justify-end">
                        <a href="{{ route('students.edit', $student) }}" class="bg-yellow-300
                        text-black py-2 px-2 rounded-md hover:bg-yellow-400">Upraviť</a>
                    </div>
                </div>
                @endif

                <div>
                    <div class="flex justify-end">
                        @if(!$student->trashed())
                            <form action="{{ route('students.destroy', $student) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-orange-500 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-orange-600 cursor-pointer">
                                    Vymazať
                                </button>
                            </form>
                        @else
                            <form action="{{ route('students.restore', $student) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="bg-blue-300 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-blue-400 cursor-pointer">
                                    Obnoviť
                                </button>
                            </form>
                            <form action="{{ route('students.forceDelete', $student) }}" method="POST"
                                  onsubmit="return confirm('Naozaj chcete žiaka trvalo vymazať ? Táto akcia sa nedá vrátiť späť.')">
                                @csrf
                                @method('DELETE')
                                <button class="cursor-pointer text-sm text-orange-500 hover:text-orange-700">
                                    Trvalo vymazať
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </x-card>

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Zákonní zástupcovia
            </h2>
            <div class="grid gap-4 sm:grid-cols-2">
                @forelse($student->guardians as $guardian)
                    <div>
                        <p class="text-sm font-medium text-slate-500">Meno</p>
                        <p class="text-slate-800">
                            {{ $guardian->user->name }}
                        </p>
                    </div>
                    <div>
                        <p class="font-medium text-slate-500">
                            Email:
                        </p>
                        <p class="text-slate-800">
                            {{ $guardian->user->email ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Používateľské meno: </p>
                        <p class="text-slate-800">
                            {{ $guardian->user->username }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Tel. č. :
                        </p>
                        <p class="text-slate-800">
                            {{ phone($guardian->phone_number) }}
                        </p>
                    </div>

                @empty
                    <p class="text-slate-500">Žiak nemá priradeného zákonného zástupcu.</p>
                @endforelse
            </div>
            @if($student->guardians->isEmpty() || $student->guardians->count() < 2)
                <div class="flex justify-end">
                    <a href="{{ route('students.guardians.create', $student) }}" class="bg-yellow-300
                        text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                        + Pridať zástupcu
                    </a>
                </div>
            @endif
        </x-card>

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Rezervácie nástrojov
            </h2>

            <div class="space-y-4">
                @forelse($student->user->instrumentReservationsFor as $reservation)
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="font-medium text-slate-800">
                            {{ $reservation->instrument->name ?? 'Neznámy nástroj' }}
                        </p>
                        <a href="#" class="bg-yellow-300 text-nlack">Upraviť</a>
                    </div>
                @empty
                    <p class="text-slate-500">Žiak nemá žiadne rezervácie nástrojov.</p>
                    <div class="flex justify-end">
                        <a href="#" class="bg-yellow-300 text-black py-2 px-2 rounded-md">Upraviť</a>
                    </div>
                @endforelse
            </div>
        </x-card>

    </div>
</x-layout>
