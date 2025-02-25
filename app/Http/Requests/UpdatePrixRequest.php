<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrixRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Autoriser tous les utilisateurs à faire cette requête
    }

    /**
     * Règles de validation.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'local_price' => 'required|numeric|min:0', // Prix local doit être un nombre positif
            'international_price' => 'required|numeric|min:0', // Prix international doit être un nombre positif
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'local_price.required' => 'Le prix local est obligatoire.',
            'local_price.numeric' => 'Le prix local doit être un nombre.',
            'local_price.min' => 'Le prix local doit être supérieur ou égal à 0.',
            'international_price.required' => 'Le prix international est obligatoire.',
            'international_price.numeric' => 'Le prix international doit être un nombre.',
            'international_price.min' => 'Le prix international doit être supérieur ou égal à 0.',
        ];
    }
}