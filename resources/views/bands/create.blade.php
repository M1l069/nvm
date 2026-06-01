<x-form form-name="Vytvoriť novú kapelu" route-name="bands.store" button-text="Vyvtoriť">
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
    <x-form.text-input name="name" placeholder="Meno kapely">
        <x-form.label :required="true" name="name">Názov kapely:</x-form.label>
    </x-form.text-input>
    <x-form.number-input name="capacity" placeholder="napr. 300">
        <x-form.label :required="true" name="capacity">Kapacita kapely:</x-form.label>
    </x-form.number-input>
    <div>
        <x-form.label name="teacher" :required="true">Učiteľ zodpovedný za kapelu:</x-form.label>
        <select
            name="teacher"
            id="teacher"
            @class(['w-full rounded-md  px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
            'border border-slate-300' => !$errors->has('teacher'),
            'border border-red-500' => $errors->has('teacher')])>
            <option value="">--Vyberte učiteľa--</option>
            @isset($responsibleTeacher)
                <option value="{{ $responsibleTeacher->id }}" @selected(old('teacher') == $responsibleTeacher->id)>
                    {{ $responsibleTeacher->user->name }}
                </option>
            @else
            @foreach($teachers as $teacher)
                <option
                    value="{{ $teacher->id }}"
                    @selected(old('teacher') == $teacher->id)>
                    {{ $teacher->user->name }}
                </option>
            @endforeach
            @endisset
        </select>
        <div>
            @error('teacher')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <x-form.label :required="false" name="description">Popis kapely:</x-form.label>
    <textarea name="description" placeholder="Popis kapely..." rows="5" id="description" @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('description'),
                        'border-slate-300' => !$errors->has('description')])>{{ old('description') }}</textarea>

</x-form>
