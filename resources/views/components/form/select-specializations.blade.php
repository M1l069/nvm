<div>
    <x-form.label name="specialization" :required="true">Špecializácia:</x-form.label>
    <select
        name="specialization"
        id="specialization"
        class="w-full rounded-md border border-slate-300 px-4 py-2 text-base
            focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
        <option value="">--Vyberte špecializáciu--</option>

        @foreach($specializations as $specialization)
            <option
                value="{{ $specialization->id }}"
                @selected(old('specialization_id') == $specialization->id)>
                {{ $specialization->name }}
            </option>
        @endforeach
    </select>
    <div>
        @error('specialization')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>
