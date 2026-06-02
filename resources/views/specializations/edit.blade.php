<x-form :put="true" route-name="specializations.update" :route-parameter="$specialization->id" form-name="Upraviť špecializáciu" button-text="Upraviť">
    <x-form.text-input name="name" placeholder="Názov špecializácie" :value="$specialization->name">
        <x-form.label :required="true" name="name">Názov špecializácie:</x-form.label>
    </x-form.text-input>

    <div>
        <x-form.label name="department_id" :required="true">Nástroj:</x-form.label>
        <select
            name="department_id"
            id="department_id"
            @class(['w-full rounded-md  px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
            'border border-slate-300' => !$errors->has('department_id'),
            'border border-red-500' => $errors->has('department_id')])>
            <option value="">--Vyberte odbor--</option>

            @foreach($departments as $department)
                <option
                    value="{{ $department->id }}"
                    @selected(old('department_id', $specialization->department->id) == $department->id)>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
        <div>
            @error('department_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
</x-form>
