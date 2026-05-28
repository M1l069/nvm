<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        return [
            'first-name' => 'required|string|max:255|regex:/^\p{L}+$/u',
            'surename' => 'required|string|max:255|regex:/^\p{L}+$/u',
            'email' => 'string|email|max:255|nullable|unique:users,email',
            'specialization' => 'required|exists:specializations,id',
            'birth_date' => 'required|date|before:today',
            'phone_number' => 'nullable|string|phone:SK',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10|regex:/^[0-9]+$/',
            'country' => 'required|string|max:255'
        ];
    }

    public function messages(): array {
        return [
            'first-name.regex' => 'V mene musia byť len písmená',
            'surename.regex' => 'V priezvisku musia byť len písmená',
            'specialization.exists' => 'Špecializácia neexistuje',
            'email.unique' => 'Tento mail je už zaregistrovaný pod iným užívateľom',
            'phone_number.phone' => 'Telefónne číslo nie je slovenské',
            'postal_code.regex' => 'PSČ musí byť číslo',
            'birth_date.before' => 'Dátum narodenia musí byť v minulosti'
        ];
    }
}
