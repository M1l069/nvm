<x-form route-name="rooms.reservations.store" :route-parameter="$room->id"
        form-name="Vytvoriť rezerváciu pre miestnosť {{ Str::lcfirst($room->name) }}" button-text="Vytvoriť">
    <div>
        <x-form.label name="from" :required="true">Začiatok rezervácie:</x-form.label>
        <input
            type="datetime-local"
            name="from"
            id="from"
            value="{{ old('from') }}"
            class="w-full rounded-md border border-slate-300
            px-4 py-2 text-base focus:border-blue-700 focus:outline-none
            focus:ring-2 focus:ring-blue-200">
        <div>
            @error('from')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div>
        <x-form.label name="to" :required="true">Koniec rezervácie:</x-form.label>
        <input
            type="datetime-local"
            name="to"
            id="to"
            value="{{ old('to') }}"
            class="w-full rounded-md border border-slate-300
            px-4 py-2 text-base focus:border-blue-700 focus:outline-none
            focus:ring-2 focus:ring-blue-200">
        <div>
            @error('to')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <x-form.label :required="false" name="description">Popis rezervácie:</x-form.label>
    <textarea name="description" placeholder="Popis rezervácie..." rows="5" id="description" @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('description'),
                        'border-slate-300' => !$errors->has('description')])>{{ old('description') }}</textarea>
</x-form>
