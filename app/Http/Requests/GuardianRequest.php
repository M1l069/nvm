<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuardianRequest extends FormRequest
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
        $guardian = $this->route('guardian');
        return [
            'first-name' => 'required|string|max:255|regex:/^\p{L}+$/u',
            'surename' => 'required|string|max:255|regex:/^\p{L}+$/u',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($guardian?->user_id)
                ->whereNull('deleted_at')],
            'phone_number' => 'nullable|string|phone:SK',
        ];
    }

    public function messages(): array {
        return [
            'first-name.regex' => 'V mene musia byť len písmená',
            'surename.regex' => 'V priezvisku musia byť len písmená',
            'email.unique' => 'Tento mail je už zaregistrovaný pod iným užívateľom',
            'phone_number.phone' => 'Telefónne číslo nie je slovenské',
        ];
    }
}
