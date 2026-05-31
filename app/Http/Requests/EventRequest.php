<?php

namespace App\Http\Requests;

use App\Enums\EventType;
use App\Enums\UserRole;
use App\Models\Event;
use App\Models\RoomReservation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'teacher' => ['required', Rule::exists('teachers', 'id')->whereNull('deleted_at')],
            'band' => ['required', Rule::exists('bands', 'id')->whereNull('deleted_at')],
            'type' => ['required', Rule::enum(EventType::class)],
            'starts_at' => 'required|date|after_or_equal:today',
            'ends_at' => 'required|date|after:starts_at',
            'room' => ['nullable', Rule::exists('rooms', 'id')->whereNull('deleted_at'),
                'required_without_all:street,city,country,postal_code'],
            'street' => 'nullable|string|max:255|required_without:room|prohibited_with:room',
            'city' => 'nullable|string|max:255|required_without:room|prohibited_with:room',
            'country' => 'nullable|string|size:2|required_without:room|prohibited_with:room',
            'postal_code' => 'nullable|string|postal_code_for:country|required_without:room|prohibited_with:room',
            'capacity' => 'nullable|integer|min:1|required_without:room|prohibited_with:room',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (! $this->filled('starts_at') || ! $this->filled('ends_at')) {
                    return;
                }

                if ($validator->errors()->has('starts_at') || $validator->errors()->has('ends_at')) {
                    return;
                }

                $eventId = $this->route('event')?->id;
                $startsAt = Carbon::parse($this->input('starts_at'));
                $endsAt = Carbon::parse($this->input('ends_at'));

                // Kontrola obsadenosti miestnosti
                if ($this->filled('room') && ! $validator->errors()->has('room')) {
                    $eventConflict = Event::where('room_id', $this->input('room'))
                        ->where('starts_at', '<', $endsAt)
                        ->where('ends_at', '>', $startsAt)
                        ->when($eventId, fn ($query) => $query->where('id', '!=', $eventId))
                        ->exists();

                    $reservationConflict = RoomReservation::where('room_id', $this->input('room'))
                        ->where('from', '<', $endsAt)
                        ->where('to', '>', $startsAt)
                        ->exists();

                    if ($eventConflict || $reservationConflict) {
                        $validator->errors()->add(
                            'room',
                            'Vybraná miestnosť je v zadanom čase už obsadená.'
                        );
                    }
                }

                // Kontrola obsadenosti učiteľa
                if ($this->filled('teacher') && ! $validator->errors()->has('teacher')) {
                    $teacherConflict = Event::where('teacher_id', $this->input('teacher'))
                        ->where('starts_at', '<', $endsAt)
                        ->where('ends_at', '>', $startsAt)
                        ->when($eventId, fn ($query) => $query->where('id', '!=', $eventId))
                        ->exists();

                    if ($teacherConflict) {
                        $validator->errors()->add(
                            'teacher',
                            'Vybraný učiteľ je v zadanom čase už priradený k inej udalosti.'
                        );
                    }
                }
            },
        ];
    }
}
