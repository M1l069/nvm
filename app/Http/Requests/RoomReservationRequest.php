<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Models\RoomReservation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

class RoomReservationRequest extends FormRequest
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
            'from' => ['required', 'date', 'after_or_equal:now'],
            'to' => 'required|date|after:from',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'from.after_or_equal' => 'Začiatok rezervácie musí byť aktuálny alebo budúci čas.',
            'from.date' => 'Začiatok rezervácie musí byť platný dátum a čas.',

            'to.after' => 'Koniec rezervácie musí byť po začiatku rezervácie.',
            'to.date' => 'Koniec rezervácie musí byť platný dátum a čas.',
        ];
    }
}
