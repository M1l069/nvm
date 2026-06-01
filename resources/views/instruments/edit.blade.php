<x-form  :put="true" :route-parameter="$instrument->id" route-name="instruments.update"
        form-name="Upraviť údaje o nástroji" button-text="Upraviť">
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
        <x-form.label name="specialization_id" :required="true">Pre špecializáciu:</x-form.label>
        <select
            name="specialization_id"
            id="specialization_id"
            @class(['w-full rounded-md  px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
            'border border-slate-300' => !$errors->has('specialization_id'),
            'border border-red-500' => $errors->has('specialization_id')])>
            <option value="">--Vyberte špecializáciu--</option>

            @foreach($specializations as $specialization)
                <option
                    value="{{ $specialization->id }}"
                    @selected(old('specialization_id', $instrument->specialization_id) == $specialization->id)>
                    {{ $specialization->name}}
                </option>
            @endforeach
        </select>
        <div>
            @error('specialization_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div>
        <x-form.label name="room_id" :required="true">Uloženie nástroja:</x-form.label>
        <select
            name="room_id"
            id="room_id"
            @class(['w-full rounded-md  px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
            'border border-slate-300' => !$errors->has('room_id'),
            'border border-red-500' => $errors->has('room_id')])>
            <option value="">--Vyberte miesnosť--</option>

            @foreach($rooms as $room)
                <option
                    value="{{ $room->id }}"
                    @selected(old('room_id', $instrument->room_id) == $room->id)>
                    {{ $room->name}}
                </option>
            @endforeach
        </select>
        <div>
            @error('band')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <x-form.text-input name="manufacturer" :value="$instrument->manufacturer" placeholder="Výrobca nástroja">
        <x-form.label :required="true" name="manufacturer">Výrobca nástroja:</x-form.label>
    </x-form.text-input>

    <x-form.text-input name="model_name" :value="$instrument->model_name" placeholder="Model nástroja">
        <x-form.label :required="true" name="manufacturer">Model nástroja:</x-form.label>
    </x-form.text-input>

    <x-form.text-input name="serial_number" :value="$instrument->serial_number" placeholder="Sériové číslo nástroja">
        <x-form.label :required="true" name="serial_number">Sériové číslo nástroja:</x-form.label>
    </x-form.text-input>
</x-form>
