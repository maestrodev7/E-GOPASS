<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'postnom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'telephone' => 'required|string|max:20|unique:super_admin_model,telephone',
            'email' => 'required|email|unique:super_admin_model,email',
            'fonction' => 'required|string|max:255',
            'poste_de_travail' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
