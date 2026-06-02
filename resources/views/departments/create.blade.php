<x-form route-name="departments.store" form-name="Vytvoriť odbor" button-text="Vytvoriť">
    <x-form.text-input name="name" placeholder="Názov odboru">
        <x-form.label :required="true" name="name">Názov odboru:</x-form.label>
    </x-form.text-input>

    <div>
        <x-form.label name="responsible_teacher_id" :required="true">Učiteľ zodpovedný za odbor:</x-form.label>
        <select
            name="responsible_teacher_id"
            id="responsible_teacher_id"
            @class(['w-full rounded-md  px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
            'border border-slate-300' => !$errors->has('responsible_teacher_id'),
            'border border-red-500' => $errors->has('responsible_teacher_id')])>
            <option value="">--Vyberte učiteľa--</option>

            @foreach($teachers as $teacher)
                <option
                    value="{{ $teacher->id }}"
                    @selected(old('responsible_teacher_id') == $teacher->id)>
                    {{ $teacher->user->name }}
                </option>
            @endforeach
        </select>
        <div>
            @error('responsible_teacher_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <x-form.label :required="false" name="description">Popis odboru:</x-form.label>
    <textarea name="description" placeholder="Popis odboru..." rows="5" id="description" @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('description'),
                        'border-slate-300' => !$errors->has('description')])>{{ old('description') }}</textarea>
    @error('description')
            <p class="text-red-500"> {{ $message }} </p>
    @enderror
</x-form>

