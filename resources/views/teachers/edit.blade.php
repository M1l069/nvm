<x-form :route-parameter="$teacher" route-name="teachers.update" form-name="Upraviť konto učiteľa"
:put="true" button-text="Upraviť">
    @php
        $parts = explode(' ', $teacher->user->name, 2);
        $firstName = $parts[0];
        $lastName = $parts[1] ?? '';
    @endphp
    <x-form.text-input placeholder="Janko" name="first-name" :value="$firstName">
        <x-form.label :required="true" name="first-name">Meno: </x-form.label>
    </x-form.text-input>

    <x-form.text-input placeholder="Hraško" name="surename" :value="$lastName">
        <x-form.label :required="true" name="surename">Priezvisko: </x-form.label>
    </x-form.text-input>

    <x-form.text-input placeholder="user@example.com" name="email" :value="$teacher->user->email">
        <x-form.label :required="true" name="email">Email: </x-form.label>
    </x-form.text-input>

    <x-form.label name="specialization" :required="true">Špecializácia:</x-form.label>
    <select
        name="specialization"
        id="specialization"
        class="w-full rounded-md border border-slate-300 px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
        <option value="">--Vyberte špecializáciu--</option>
        <option
            value="{{ $teacher->specialization->id }}"
            @selected(old('specialization', $teacher->specialization->id) == $teacher->specialization->id)>
            {{ $teacher->specialization->name }}
        </option>
    </select>
    <div>
        @error('specialization')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
</x-form>
