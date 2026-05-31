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
                    @if($student->user->email)
                        <a href="mailto:{{ $student->user->email }}"
                           class="text-slate-800 hover:text-blue-800">{{ $student->user->email }}</a>
                    @else
                        -
                    @endif
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
                    @if($student->phone_number)
                        <a href="tel:{{ phone($student->phone_number)->formatInternational() }}" class="text-slate-800
                        hover:text-blue-800">{{ $student->phone_number }}</a>
                    @else
                        -
                    @endif
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
                    @if(!$student->trashed())
                        <div class="flex justify-end">
                            <form action="{{ route('students.destroy', $student) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-orange-500 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-orange-600 cursor-pointer">
                                    Vymazať
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex justify-end">
                            <form action="{{ route('students.restore', $student) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="bg-blue-300 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-blue-400 cursor-pointer">
                                    Obnoviť
                                </button>
                            </form>
                        </div>
                        <div class="flex justify-end">
                            <form action="{{ route('students.forceDelete', $student) }}" method="POST"
                                  onsubmit="return confirm('Naozaj chcete žiaka trvalo vymazať ? Táto akcia sa nedá vrátiť späť.')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-orange-500 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-orange-600 cursor-pointer">
                                    Trvalo vymazať
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        </x-card>

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Zákonní zástupcovia
            </h2>
            <div class="grid gap-4 sm:grid-cols-2">
                @php
                    $count = $student->guardians->count();
                @endphp
                @forelse($student->guardians as $guardian)
                    @if($loop->last && $count > 1)
                        <hr class="col-span-2 border-slate-300">
                    @endif
                    <div>
                        <p class="text-sm font-medium text-slate-500">Meno</p>
                        <a class="text-slate-800 hover:text-blue-800"
                           href="{{ route('students.guardians.show', ['student' => $student, 'guardian' => $guardian]) }}">
                            {{ $guardian->user->name }}
                            @if($guardian->trashed())
                                <span class="text-red-500 ml-4">Vymazaný</span>
                            @endif
                        </a>
                    </div>
                    <div>
                        <p class="font-medium text-slate-500">
                            Email:
                        </p>
                        <a href="mailto:{{ $guardian->user->email }}" class="text-slate-800 hover:text-blue-800">
                            {{ $guardian->user->email }}
                        </a>
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
                        <a href="tel:{{ phone($guardian->phone_number)->formatInternational() }}"
                           class="text-slate-800 hover:text-blue-800">
                            {{ phone($guardian->phone_number) }}
                        </a>
                    </div>
                    @if($guardian->trashed() && auth()->user()->role === \App\Enums\UserRole::Admin)
                        <div class="col-span-2 flex justify-end">
                            <form
                                action="{{ route('students.guardians.restore', ['student' => $student->id, 'guardian' => $guardian->id]) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="py-2 px-2 bg-blue-300 cursor-pointer hover:bg-blue-400 rounded-md shadow-md border-slate-100">
                                    Obnoviť
                                </button>
                            </form>
                        </div>
                    @endif
                    <div class="col-span-2 flex justify-end mb-4">
                        <a href="{{ route('students.guardians.show', ['student' => $student, 'guardian' => $guardian]) }}"
                        class="bg-yellow-300 text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            Zobraziť
                        </a>
                    </div>
                @empty
                    <p class="text-slate-500">Žiak nemá priradeného zákonného zástupcu.</p>
                @endforelse
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                @if($student->guardians->isEmpty() || $student->guardians->count() < 2)
                    <div class="flex justify-end">
                        <a href="{{ route('students.guardians.create', $student) }}" class="bg-yellow-300
                            text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            + Pridať zástupcu
                        </a>
                    </div>
                @endif
            @endif

        </x-card>
    </div>
</x-layout>
