<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'    => 'required|string|max:255',
            'floors'  => 'required|integer|min:1',
            'address' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'name.required'    => "Le nom de l'immeuble est obligatoire.",
            'floors.required'  => "Le nombre d'étages est obligatoire.",
            'floors.min'       => "L'immeuble doit avoir au moins 1 étage.",
            'address.required' => "L'adresse est obligatoire.",
        ];
    }
}
