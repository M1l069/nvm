<x-form form-name="Vytvorenie konta žiaka" button-text="Vytvoriť" route-name="students.store">
    <x-form.text-input name="first-name"  placeholder="Janko">
        <x-form.label name="first-name" :required="true">Meno: </x-form.label>
    </x-form.text-input>
    <x-form.text-input name="surename" placeholder="Hraško">
        <x-form.label name="surename" :required="true">Priezvisko: </x-form.label>
    </x-form.text-input>
    <x-form.text-input name="email" placeholder="user@example.com">
        <x-form.label name="email" :required="false">Email: </x-form.label>
    </x-form.text-input>

    <x-form.select-specializations :specializations="$specializations"/>

    <div>
        <x-form.label name="birth_date" :required="true">Dátum narodenia: </x-form.label>
        <input
            type="date"
            name="birth_date"
            id="birth_date"
            value="{{ old('birth_date') }}"
            class="w-full rounded-md border border-slate-300
            px-4 py-2 text-base focus:border-blue-700 focus:outline-none
            focus:ring-2 focus:ring-blue-200">
        <div>
        @error('birth_date')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
        </div>
    </div>

    <x-form.text-input name="phone_number" placeholder="+421..." input-mode="numeric">
        <x-form.label name="phone_number" :required="false">Tel. č. :</x-form.label>
    </x-form.text-input>

    <div>
        <h3 class="text-l text-slate-700 font-medium">Bydlisko</h3>
    </div>

    <x-form.text-input name="street" placeholder="Košická">
        <x-form.label name="street" :required="true">Ulica: </x-form.label>
    </x-form.text-input>

    <x-form.text-input name="postal_code"  placeholder="821" input-mode="numeric">
        <x-form.label name="postal_code" :required="true">PSČ: </x-form.label>
    </x-form.text-input>

    <x-form.text-input name="city"  placeholder="Bratislava">
        <x-form.label name="city" :required="true">Mesto: </x-form.label>
    </x-form.text-input>

    <x-form.text-input name="country" placeholder="Slovensko">
        <x-form.label name="country" :required="true">Krajina: </x-form.label>
    </x-form.text-input>
</x-form>

