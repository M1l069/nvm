<x-layout>
    <div class="flex items-center justify-center px-4 py-10 sm:items-center sm:py-16">
        <article class="w-full max-w-lg rounded-xl border border-slate-300 bg-white p-6 shadow-md sm:p-8">
            <h1 class="mb-8 text-center text-3xl font-semibold sm:text-4xl">Úprava konta zástupcu</h1>
            <form action="{{ route('students.guardians.update', ['student' => $student, 'guardian' => $guardian]) }}" class="space-y-5" method="POST">
                @csrf
                @method('PUT')
                @php
                    $parts = explode(' ', $guardian->user->name, 2);
                    $firstName = $parts[0];
                    $lastName = $parts[1] ?? '';
                @endphp
                <x-form.text-input name="first-name" :value="$firstName" placeholder="Janko">
                    <x-form.label name="first-name" :required="true">Meno: </x-form.label>
                </x-form.text-input>

                <x-form.text-input name="surename" :value="$lastName" placeholder="Hraško">
                    <x-form.label name="surename" :required="true">Priezvisko: </x-form.label>
                </x-form.text-input>

                <x-form.text-input name="email" :value="$guardian->user->email" placeholder="user@example.com">
                    <x-form.label name="email" :required="true">E-mail: </x-form.label>
                </x-form.text-input>

                <x-form.text-input name="phone_number" :value="phone($student->phone_number)->formatInternational()" placeholder="+421...">
                    <x-form.label name="phone_number" :required="true">Tel. č. :</x-form.label>
                </x-form.text-input>

                <div class="mt-3 pt-2 flex justify-end">
                    <button
                        type="submit"
                        class="w-full cursor-pointer rounded-md
                        bg-yellow-300 px-4 py-3 font-medium text-black shadow-md
                        hover:bg-yellow-500 sm:w-auto sm:px-6">
                        Upraviť
                    </button>
                </div>
            </form>
        </article>
    </div>
</x-layout>
