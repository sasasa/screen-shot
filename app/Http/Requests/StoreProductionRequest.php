<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_type' => 'required|integer|min:1|max:3',
            'name' => 'required|string|max:255',
            'kana' => 'required|string|max:255',
            'representative' => 'required|string|max:255',
            'inquiry_email' => 'required|string|email:strict,dns,spoof|max:255|unique:productions,inquiry_email,'. $this->user()->id . ',id',
            'postal' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'staff' => 'required|integer|min:1|max:7',
            'achievement' => 'required|string|max:5000',
            'introduction' => 'required|string|max:5000',
        ];
    }
}
