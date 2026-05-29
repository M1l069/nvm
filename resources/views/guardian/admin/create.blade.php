<x-form form-name="Vytvorenie zákonného zástupcu pre {{ $student->user->username }}"
        button-text="Vytvoriť" route-name="students.guardians.store" :route-parameter="$student->id">
    <x-form.text-input name="first-name" placeholder="Janko">
        <x-form.label name="first-name" :required="true">Meno: </x-form.label>
    </x-form.text-input>

    <x-form.text-input name="surename" placeholder="Hraško">
        <x-form.label name="surename" :required="true">Priezvisko: </x-form.label>
    </x-form.text-input>

    <x-form.text-input name="email" placeholder="user@example.com">
        <x-form.label name="email" :required="true">E-mail: </x-form.label>
    </x-form.text-input>

    <x-form.text-input name="phone_number" placeholder="+421..." input-mode="numeric">
        <x-form.label name="phone_number" :required="true">Tel. č. :</x-form.label>
    </x-form.text-input>
</x-form>
