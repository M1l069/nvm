<x-form :put="true" :route-parameter="$instruments_reservation->id" route-name="instruments-reservations.update"
        form-name="Upraviť údaje o rezervácií nástroja" button-text="Upraviť">
    @if($errors->any())
        <div class="mx-auto mt-8 w-full max-w-lg px-4">
            <div role="alert" class="rounded-md border-l-4 border-red-300 bg-red-100 p-4 text-red-700 opacity-75">
                <ul class="mt-2 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div>
        <x-form.label name="instrument_id" :required="true">Nástroj:</x-form.label>
        <select
            name="instrument_id"
            id="instrument_id"
            @class(['w-full rounded-md  px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
            'border border-slate-300' => !$errors->has('instrument_id'),
            'border border-red-500' => $errors->has('instrument_id')])>
            <option value="">--Vyberte nástroj--</option>

            @foreach($instruments as $instrument)
                <option
                    value="{{ $instrument->id }}"
                    @selected(old('instrument_id', $instruments_reservation->instrument->id) == $instrument->id)>
                    {{ $instrument->manufacturer }} {{ $instrument->model_name }} {{ $instrument->serial_number }}
                </option>
            @endforeach
        </select>
        <div>
            @error('instrument_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <x-form.label name="reserved_for" :required="true">Rezervovať pre:</x-form.label>
        <select
            name="reserved_for"
            id="reserved_for"
            @class(['w-full rounded-md  px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
            'border border-slate-300' => !$errors->has('reserved_for'),
            'border border-red-500' => $errors->has('reserved_for')])>
            <option value="">--Vyberte používateľa--</option>

            @foreach($users as $user)
                <option
                    value="{{ $user->id }}"
                    @selected(old('reserved_for', $instruments_reservation->reserved_for) == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        <div>
            @error('reserved_for')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

        <div>
            <x-form.label name="status" :required="true">Stav rezervácie:</x-form.label>
            <select
                name="status"
                id="status"
                @class(['w-full rounded-md  px-4 py-2 text-base
                focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                'border border-slate-300' => !$errors->has('status'),
                'border border-red-500' => $errors->has('status')])>
                <option value="">--Vyberte stav rezervácie--</option>

                @foreach(\App\Enums\InstrumentReservationStatus::cases() as $type)
                    <option
                        value="{{ $type->value }}"
                        @selected(old('type', $instruments_reservation->status->value) == $type->value)>
                        {{ $type->label()}}
                    </option>
                @endforeach
            </select>
            <div>
                @error('status')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

    <div>
        <x-form.label name="from" :required="true">Od:</x-form.label>
        <input
            type="datetime-local"
            name="from"
            id="from"
            value="{{ old('from', $instruments_reservation->from) }}"
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
        <x-form.label name="to" :required="true">Do:</x-form.label>
        <input
            type="datetime-local"
            name="to"
            id="to"
            value="{{ old('to', $instruments_reservation->to) }}"
            class="w-full rounded-md border border-slate-300
            px-4 py-2 text-base focus:border-blue-700 focus:outline-none
            focus:ring-2 focus:ring-blue-200">
        <div>
            @error('from')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <x-form.label :required="false" name="description">Popis rezervácie:</x-form.label>
    <textarea name="description" placeholder="Popis rezervácie..." rows="5" id="description" @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('description'),
                        'border-slate-300' => !$errors->has('description')])>{{ old('description', $instruments_reservation->description) }}</textarea>

</x-form>
