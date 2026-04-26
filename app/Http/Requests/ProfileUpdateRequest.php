<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'ville' => ['nullable', 'string', 'max:255'],
            'genre' => ['nullable', 'in:Homme,Femme'],
            'date_naissance' => ['nullable', 'date'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'type_addiction' => ['nullable', 'string', 'max:255'],
            'specialite' => ['nullable', 'string', 'max:255'],
            'association_nom' => ['nullable', 'string', 'max:255'],
            'association_description' => ['nullable', 'string'],
        ];
    }
}
