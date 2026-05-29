<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 space-y-6 mb-8">

        <x-card>
            <h2 class="mb-4 text-xl font-semibold text-slate-800">
                Informácie o zákonnom zástupcovi žiaka {{ $student->user->name }}
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
            </div>
        </x-card>
    </div>
</x-layout>
