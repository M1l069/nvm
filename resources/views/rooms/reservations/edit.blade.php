<x-layout>
    <div class="flex items-center justify-center px-4 py-10 sm:items-center sm:py-16">
        <article class="w-full max-w-lg rounded-xl border border-slate-300 bg-white p-6 shadow-md sm:p-8">
            <h1 class="mb-8 text-center text-3xl font-semibold sm:text-4xl">Upraviť Rezerváciu</h1>
            <form action="{{ route('rooms.reservations.update',  [$room, $reservation]) }}" class="space-y-5" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <x-form.label name="from" :required="true">Začiatok rezervácie:</x-form.label>
                    <input
                        type="datetime-local"
                        name="from"
                        id="from"
                        value="{{ old('from', $reservation->from) }}"
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
                    <x-form.label name="to" :required="true">Začiatok rezervácie:</x-form.label>
                    <input
                        type="datetime-local"
                        name="to"
                        id="to"
                        value="{{ old('to', $reservation->to) }}"
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
                        'border-slate-300' => !$errors->has('description')])>{{ old('description', $reservation->description) }}</textarea>
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
