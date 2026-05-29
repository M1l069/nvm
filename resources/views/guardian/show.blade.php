<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o zákonnom zástupcovi žiaka
                <a href="{{ route('students.show', $student) }}" class="hover:text-blue-500">{{ $student->user->name }}</a>
            </h2>
            <div class="grid gap-4 sm:grid-cols-2">
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
                        <a href="mailto:{{ $guardian->user->email }}" class="text-blue-800">
                            {{ $guardian->user->email ?? '-' }}
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
                        <a href="tel:{{ $guardian->phone_number }}" class="text-blue-800">
                            {{ phone($guardian->phone_number)->formatInternational() }}
                        </a>
                    </div>
                    <div>

                    </div>
            </div>
            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                @if(!$guardian->trashed())
                    <div class="flex justify-end">
                        <a href="{{ route('students.guardians.edit',['student' => $student, 'guardian' => $guardian]) }}"
                           class="bg-yellow-300
                        text-black py-2 px-2 rounded-md hover:bg-yellow-400">
                            Upraviť
                        </a>
                    </div>
                    <div class="flex justify-end">
                        <form action="{{ route('students.guardians.destroy', ['student' => $student, 'guardian' => $guardian]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-orange-500 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-orange-600 cursor-pointer">
                                Vymazať
                            </button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('students.guardians.restore', ['student' => $student, 'guardian' => $guardian]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button
                            class="bg-blue-300 mt-4 text-black py-2 px-2 rounded-md shadow-md hover:bg-blue-400 cursor-pointer">
                            Obnoviť
                        </button>
                    </form>
                @endif
            @endif
        </x-card>
    </div>
</x-layout>
