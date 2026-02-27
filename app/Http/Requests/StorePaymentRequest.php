<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tenant_id' => 'required|exists:users,id',
            'apartment_id' => 'required|exists:apartments,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
        ];
    }
}
