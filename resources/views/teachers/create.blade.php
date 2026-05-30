<x-form route-name="teachers.store" form-name="Vytvoriť učiteľa" button-text="Vytvoriť">
    <x-form.text-input placeholder="Janko" name="first-name">
        <x-form.label :required="true" name="first-name">Meno: </x-form.label>
    </x-form.text-input>

    <x-form.text-input placeholder="Hraško" name="surename">
        <x-form.label :required="true" name="surename">Priezvisko: </x-form.label>
    </x-form.text-input>

    <x-form.text-input placeholder="user@example.com" name="email">
        <x-form.label :required="true" name="email">Email: </x-form.label>
    </x-form.text-input>

    <x-form.select-specializations :specializations="$specializations"/>
</x-form>
