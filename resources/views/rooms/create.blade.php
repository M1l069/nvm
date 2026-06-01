<x-form route-name="rooms.store" form-name="Vytvoriť miestnosť" button-text="Vytvoriť">
    <x-form.text-input name="name" placeholder="Názov miestnosti">
        <x-form.label :required="true" name="name">Názov miestnosti</x-form.label>
    </x-form.text-input>

    <x-form.number-input name="capacity" placeholder="napr. 300">
        <x-form.label :required="true" name="capacity">Kapacita miestnosti</x-form.label>
    </x-form.number-input>

    <x-form.label :required="false" name="description">Popis miestnosti:</x-form.label>
    <textarea name="description" placeholder="Popis miestnosti..." rows="5" id="description" @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('description'),
                        'border-slate-300' => !$errors->has('description')])>{{ old('description') }}</textarea>

</x-form>
