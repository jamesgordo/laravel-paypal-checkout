<?php

namespace JamesGordo\LaravelPaypalCheckout\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'item' => 'required',
        ];
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return (float) $this->input('amount', 0);
    }

    /**
     * @return string
     */
    public function getItem(): string
    {
        return $this->input('item');
    }
}
