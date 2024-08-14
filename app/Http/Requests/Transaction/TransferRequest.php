<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'value' => ['required', 'numeric'],
            'payer' => ['required', 'integer'],
            'payee' => ['required', 'integer'],
        ];
    }
}
