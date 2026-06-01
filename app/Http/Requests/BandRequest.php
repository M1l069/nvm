<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BandRequest extends FormRequest
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
            'teacher' => 'required|exists:teachers,id',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ];
    }

    public function after(): array {
        return [
            function (Validator $validator) {
                $band = $this->route('band');

                if (! $band || ! $this->filled('capacity')) {
                    return;
                }

                $studentsCount = $band->students()->count();

                if ((int) $this->input('capacity') < $studentsCount) {
                    $validator->errors()->add(
                        'capacity',
                        'Kapacita kapely nemôže byť menšia ako aktuálny počet členov kapely.');
                }
            },
        ];
    }
}
