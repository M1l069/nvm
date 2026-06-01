<x-form route-name="bands.students.store" form-name="Pridať žiaka do kapely {{ Str::lcfirst($band->name) }}"
        button-text="Pridať žiaka" :route-parameter="$band->id">
    <div>
        <x-form.label name="student_id" :required="true">Žiak:</x-form.label>
        <select
            name="student_id"
            id="student_id"
            @class(['w-full rounded-md  px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
            'border border-slate-300' => !$errors->has('teacher'),
            'border border-red-500' => $errors->has('teacher')])>
            <option value="">--Vyberte žiaka--</option>
            @foreach($students as $student)
                <option
                    value="{{ $student->id }}"
                    @selected(old('student_id') == $student->id)>
                    {{ $student->user->name }}
                </option>
            @endforeach
        </select>
        <div>
            @error('student_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
</x-form>
