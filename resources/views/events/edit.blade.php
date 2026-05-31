<x-layout>
    <div class="flex items-center justify-center px-4 py-10 sm:items-center sm:py-16">
        <article class="w-full max-w-lg rounded-xl border border-slate-300 bg-white p-6 shadow-md sm:p-8">
            <h1 class="mb-8 text-center text-3xl font-semibold sm:text-4xl">Upraviť udalosť</h1>
            <form action="{{ route('events.update', $event) }}" class="space-y-5" method="POST">
                @csrf
                @method('PUT')
                <x-form.text-input name="name" placeholder="Názov udalosti" :value="$event->name">
                    <x-form.label :required="true" name="name">Názov udalosti:</x-form.label>
                </x-form.text-input>

                <div>
                    <x-form.label name="teacher" :required="true">Učiteľ zodpovedný za udalosť:</x-form.label>
                    <select
                        name="teacher"
                        id="teacher"
                        @class(['w-full rounded-md  px-4 py-2 text-base
                        focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border border-slate-300' => !$errors->has('teacher'),
                        'border border-red-500' => $errors->has('teacher')])>
                        <option value="">--Vyberte učiteľa--</option>

                        @foreach($teachers as $teacher)
                            <option
                                value="{{ $teacher->id }}"
                                @selected(old('teacher', $event->teacher_id) == $teacher->id)>
                                {{ $teacher->user->name }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error('teacher')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-form.label name="band" :required="true">Kapela na koncerte:</x-form.label>
                    <select
                        name="band"
                        id="band"
                        @class(['w-full rounded-md  px-4 py-2 text-base
                        focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border border-slate-300' => !$errors->has('band'),
                        'border border-red-500' => $errors->has('band')])>
                        <option value="">--Vyberte kapelu--</option>

                        @foreach($bands as $band)
                            <option
                                value="{{ $band->id }}"
                                @selected(old('band', $event->bands->first()?->id) == $teacher->id)>
                                {{ $band->name}}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error('band')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-form.label name="type" :required="true">Typ udalosti:</x-form.label>
                    <select
                        name="type"
                        id="type"
                        @class(['w-full rounded-md  px-4 py-2 text-base
                        focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border border-slate-300' => !$errors->has('type'),
                        'border border-red-500' => $errors->has('type')])>
                        <option value="">--Vyberte typ udalosti--</option>

                        @foreach(\App\Enums\EventType::cases() as $type)
                            <option
                                value="{{ $type->value }}"
                                @selected(old('type', $event->type->value) == $type->value)>
                                {{ $type->label()}}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error('type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-form.label name="starts_at" :required="true">Začiatok udalosti:</x-form.label>
                    <input
                        type="datetime-local"
                        name="starts_at"
                        id="starts_at"
                        value="{{ old('starts_at', $event->starts_at->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-md border border-slate-300
            px-4 py-2 text-base focus:border-blue-700 focus:outline-none
            focus:ring-2 focus:ring-blue-200">
                    <div>
                        @error('starts_at')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-form.label name="ends_at" :required="true">Koniec udalosti:</x-form.label>
                    <input
                        type="datetime-local"
                        name="ends_at"
                        id="ends_at"
                        value="{{ old('ends_at', $event->ends_at->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-md border border-slate-300
            px-4 py-2 text-base focus:border-blue-700 focus:outline-none
            focus:ring-2 focus:ring-blue-200">
                    <div>
                        @error('ends_at')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div x-data="{ roomSelected: @js(old('room', $event->room_id) !== null && old('room', $event->room_id) !== '') }">
                    <div class="mb-4">
                        <x-form.label name="room" :required="false">Miestnosť</x-form.label>
                        <select
                            name="room"
                            id="room"
                            x-on:change="roomSelected = $event.target.value !== ''"
                            @class(['w-full rounded-md  px-4 py-2 text-base
                        focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border border-slate-300' => !$errors->has('room'),
                        'border border-red-500' => $errors->has('room')])>
                            <option value="">--Vyberte miestnosť--</option>

                            @foreach($rooms as $room)
                                <option
                                    value="{{ $room->id }}"
                                    @selected(old('room', $event->room_id) == $room->id)>
                                    {{ $room->name  }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            @error('room')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div x-show="!roomSelected" x-cloak>
                        <x-form.text-input name="street" placeholder="Ulica" :value="$event->street">
                            <x-form.label :required="false" name="street">Ulica:</x-form.label>
                        </x-form.text-input>

                        <div class="mt-4">
                            <x-form.text-input name="postal_code" placeholder="PSČ" :value="$event->postal_code">
                                <x-form.label name="postal_code" :required="false">PSČ:</x-form.label>
                            </x-form.text-input>
                        </div>

                        <div class="mt-4">
                            <x-form.text-input name="city" placeholder="Bratislava" :value="$event->city">
                                <x-form.label name="city" :required="false">Mesto:</x-form.label>
                            </x-form.text-input>
                        </div>

                        <div class="mt-4">
                            <x-form.label name="country" :required="false">Krajina:</x-form.label>
                            <select
                                name="country"
                                id="country"
                                @class(['w-full rounded-md  px-4 py-2 text-base
                        focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border border-slate-300' => !$errors->has('room'),
                        'border border-red-500' => $errors->has('room')])>
                                <option value="">--Vyberte krajinu--</option>

                                @foreach($countries as $code => $country)
                                    <option
                                        value="{{ $code }}"
                                        @selected(old('country', $event->country) == $code)>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>
                            <div>
                                @error('country')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-form.number-input name="capacity" placeholder="napr. 300" :value="$event->capacity">
                                <x-form.label :required="false" name="capacity">Kapacita udalosti: </x-form.label>
                            </x-form.number-input>
                        </div>
                    </div>
                </div>

                <x-form.label :required="false" name="description">Popis udalosti:</x-form.label>
                <textarea name="description" placeholder="Popis udalosti..." rows="5" id="description" @class(['w-full rounded-md border px-4 py-2 text-base
                        placeholder:text-slate-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200',
                        'border-red-300' => $errors->has('description'),
                        'border-slate-300' => !$errors->has('description')])>{{ old('description', $event->description) }}</textarea>
                <div class="flex items-center justify-end gap-3">
                    <x-form.label name="is_public" :required="false">
                        Udalosť je dostupná pre verejnosť
                    </x-form.label>
                    <input
                        type="checkbox"
                        name="is_public"
                        id="is_public"
                        value="1"
                        @checked(old('is_public', $event->is_public))
                        class="h-4 w-4 rounded border-slate-300 text-yellow-400 focus:ring-yellow-300"
                    >
                </div>
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

