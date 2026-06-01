<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InstrumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === UserRole::Admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'manufacturer' => 'required|string|max:255',
            'model_name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'specialization_id' => 'required|integer|exists:specializations,id',
            'room_id' => 'required|integer|exists:rooms,id',
        ];
    }
}
