<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === UserRole::Admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $teacher = $this->route('teacher');
        return [
            'first-name' => 'required|string|max:255|regex:/^\p{L}+$/u',
            'surename' => 'required|string|max:255|regex:/^\p{L}+$/u',
            'email' => ['email', 'max:255', 'required', Rule::unique('users', 'email')->ignore($teacher?->user_id)
                ->whereNull('deleted_at')],
            'specialization' => 'required|exists:specializations,id',
        ];
    }

    public function messages(): array {
        return [
            'first-name.regex' => 'V mene musia byť len písmená',
            'surename.regex' => 'V priezvisku musia byť len písmená',
            'specialization.exists' => 'Špecializácia neexistuje',
            'email.unique' => 'Tento mail je už zaregistrovaný pod iným užívateľom',
        ];
    }
}
