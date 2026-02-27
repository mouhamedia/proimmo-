<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'building_id' => 'required|exists:buildings,id',
            'number' => 'required',
            'type' => 'required',
            'rent_amount' => 'required|numeric',
            'status' => 'required',
        ];
    }
}
