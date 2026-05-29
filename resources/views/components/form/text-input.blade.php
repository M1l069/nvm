<div>
    {{ $slot }}
    <input type="text" name="{{ $name }}" id="{{ $name }}" @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has($name),
                        'border-slate-300' => !$errors->has($name)]) @if($inputMode) inputmode="{{ $inputMode }}" @endif placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}">
    @error($name)
    <div>
        <p class="text-sm mt-1 text-red-500">
            {{ $message }}
        </p>
    </div>
    @enderror
</div>
