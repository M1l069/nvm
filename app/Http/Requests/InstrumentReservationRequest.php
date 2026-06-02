<?php

namespace App\Http\Requests;

use App\Enums\InstrumentReservationStatus;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InstrumentReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === UserRole::Admin || auth()->user()->role === UserRole::Teacher;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('PUT')) {
            return [
                'instrument_id' => 'required|exists:instruments,id',
                'reserved_for' => 'required|exists:users,id',
                'from' => 'required|date|after_or_equal:now',
                'to' => 'required|date|after:from',
                'description' => 'nullable|string',
                'status' => ['required', Rule::enum(InstrumentReservationStatus::class)]
            ];
        }
        else {
            return [
                'instrument_id' => 'required|exists:instruments,id',
                'reserved_for' => 'required|exists:users,id',
                'from' => 'required|date|after_or_equal:now',
                'to' => 'required|date|after:from',
                'description' => 'nullable|string',
            ];
        }
    }
}
