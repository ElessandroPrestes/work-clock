<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfRule;


class StoreFuncionarioRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');
        
        return [
            'name' => ['required', 'string', 'min:3'],
            'cpf' => ['required', 'string', 'size:11', new CpfRule(), "unique:users,cpf,$id"],
            'email' => ['required', 'email', "unique:users,email,$id"],
            'password' => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'min:6'],
            'cargo' => ['required', 'string'],
            'data_nascimento' => ['required', 'date'],
            'cep' => ['required', 'string', 'size:8'],
        ];
    }
}
