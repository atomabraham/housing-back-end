<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //les donnees qui vont etre reçus dans la requete
            'userName' => 'string|max:255',
            'name' => 'required|string|max:255',
            'secondname' => 'string|max:255',
            'secondname' => 'string|max:255',
            'phone' => 'integer',
            'birthday' => 'date|max:255',
            'country' => 'string|max:255',
            'city' => 'string|max:255',
            'postalcode' => 'string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),
                'confirmed',
            ]
        ];
    }
}
