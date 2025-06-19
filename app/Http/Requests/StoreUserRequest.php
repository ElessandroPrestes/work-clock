<?php

namespace App\Http\Requests;

use App\Rules\BrazilianZipCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CpfRule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'unique:users,cpf', new CpfRule],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'employee'])],
            'position' => ['required', 'string', 'max:100'],
            'birthdate' => ['required', 'date', 'before:today'],
            'zip_code' => ['required', 'string', new BrazilianZipCode()],
            'manager_id' => ['nullable', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.unique' => 'Este e-mail já está em uso.',
            'zip_code.required' => 'O CEP deve estar no formato 00000-000 ou apenas números.',
            'birthdate.before' => 'A data de nascimento deve ser anterior a hoje.',
        ];
    }
}
