<x-layout>
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
    <div class="flex items-center justify-center px-4 py-10 sm:items-center sm:py-16">
        <article class="w-full max-w-lg rounded-xl border border-slate-300 bg-white p-6 shadow-md sm:p-8">
            <h1 class="mb-8 text-center text-3xl font-semibold sm:text-4xl">Upraviť kapelu</h1>
            <form action="{{ route('bands.update', $band) }}" class="space-y-5" method="POST">
                @csrf
                @method('PUT')
                <x-form.text-input name="name" placeholder="Názov kapely" :value="$band->name">
                    <x-form.label name="name" :required="true">Názov kapely:</x-form.label>
                </x-form.text-input>
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
                        @isset($teacher)
                            <option value="{{ $teacher->id }}" @selected(old('teacher', $band->teacher_id) == $teacher->id)>
                                {{ $teacher->user->name }}
                            </option>
                        @else
                            @foreach($teachers as $teacher)
                                <option
                                    value="{{ $teacher->id }}"
                                    @selected(old('teacher', $band->teacher_id) == $teacher->id)>
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
                <x-form.number-input name="capacity" :value="$band->capacity" placeholder="napr. 300">
                    <x-form.label :required="true" name="capacity">Kapacita kapely:</x-form.label>
                </x-form.number-input>
                <x-form.label name="description" :required="false">Popis kapely:</x-form.label>
                <textarea name="description" placeholder="Popis kapely..." rows="5" id="description" @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('description'),
                        'border-slate-300' => !$errors->has('description')])>{{ old('description', $band->description) }}</textarea>
                <div class="mt-3 pt-2 flex justify-end">
                    <button
                        type="submit"
                        class="w-full cursor-pointer rounded-md
                        bg-yellow-300 px-4 py-3 font-medium text-black shadow-md
                        hover:bg-yellow-500 sm:w-auto sm:px-6">
                        Upraviť
                    </button>
                </div>
            </form>
        </article>
    </div>
</x-layout>
