

<x-form form-name="Prihlásenie" button-text="Prihlásiť sa" route-name="auth.store">
    <x-form.text-input name="username" placeholder="xuser">
    <x-form.label :required="true" name="username">Používateľské meno: </x-form.label>
    </x-form.text-input>
    <x-auth.password-input name="password" label="Heslo: "/>
</x-form>
