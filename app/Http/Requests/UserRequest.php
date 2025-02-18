<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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

     protected function failedValidation(Validator $validator)
     {
        throw new HttpResponseException(response()->json([
            'status'=> false,
            'errors'=>$validator->errors(),
        ],422));
     }
    public function rules(): array
    {
        $user = $this->route('user');
        return [
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.($user? $user->id:null),
            'password'=>'required|min:6'
        ];
    }

    public function messages():array{
        return[
            'nome.required'=>'Campo nome é obrigatório!',
            'email.required'=>'Campo e-mail é obrigatório!',
            'email.email'=>'E-mail inválido! Tente novamente com um e-mail válido!',
            'email.unique'=>'O e-mail já está cadastrado!',
            'password.required'=> 'Campo senha é obrigatório!',
            'password.min'=> 'A senha deve ter no mínimo :min caracteres!',
        ];
    }
}
